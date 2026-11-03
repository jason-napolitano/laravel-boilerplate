<?php

namespace App\Services\Auth {


    use App\Models\OtpData;
    use App\Models\User;
    use Illuminate\Support;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Validation\ValidationException;

    class OTPService
    {
        public const int EXPIRATION_MINUTES = 5;

        public const int MAX_ATTEMPTS = 5;

        protected const int RESEND_COOLDOWN_SECONDS = 60;

        protected const int MAX_RESENDS = 3;

        /**
         * Generate and store a new OTP challenge.
         */
        public function create(User $user): array
        {
            $code = (string)random_int(100000, 999999);

            $challenge = Support\Str::random(64);

            OtpData::create([
                'user_id'        => $user->id,
                'token_hash'     => Support\Facades\Hash::make($code),
                'challenge_hash' => hash('sha256', $challenge),
                'expires_at'     => now()->addMinutes(self::EXPIRATION_MINUTES),
                'last_sent_at'   => now(),
                'resend_count'   => 0,
            ]);

            return [
                'challenge' => $challenge,
                'code'      => $code,
            ];
        }

        /**
         * Verify an OTP challenge.
         */
        public function verify(string $challenge, string $code): ?User
        {
            return Support\Facades\DB::transaction(function () use ($challenge, $code) {
                $otp = OtpData::query()
                    ->where(
                        'challenge_hash',
                        hash('sha256', $challenge)
                    )
                    ->lockForUpdate()
                    ->first();

                if (!$otp) {
                    return null;
                }

                if ($otp->verified_at !== null) {
                    return null;
                }

                if ($otp->expires_at->isPast()) {
                    return null;
                }

                if ($otp->attempts >= self::MAX_ATTEMPTS) {
                    return null;
                }

                if (!Support\Facades\Hash::check($code, $otp->token_hash)) {
                    $otp->increment('attempts');

                    return null;
                }

                $otp->update([
                    'verified_at' => now(),
                ]);

                return $otp->user;
            });
        }

        public function resend(string $challenge): array
        {
            return DB::transaction(function () use ($challenge) {
                $otp = OtpData::query()
                    ->where('challenge_hash', hash('sha256', $challenge))
                    ->lockForUpdate()
                    ->first();

                if (!$otp || $otp->verified_at || $otp->expires_at->isPast()) {
                    throw ValidationException::withMessages([
                        'resend' => 'Your login challenge has expired. Please log in again.',
                    ]);
                }

                if ($otp->attempts >= self::MAX_ATTEMPTS) {
                    throw ValidationException::withMessages([
                        'resend' => 'Too many verification attempts. Please log in again.',
                    ]);
                }

                if ($otp->resend_count >= self::MAX_RESENDS) {
                    throw ValidationException::withMessages([
                        'resend' => 'You have reached the maximum number of resend requests.',
                    ]);
                }

                if ($otp->last_sent_at && $otp->last_sent_at->diffInSeconds(now()) < self::RESEND_COOLDOWN_SECONDS) {
                    throw ValidationException::withMessages([
                        'resend' => 'Please wait before requesting another code.',
                    ]);
                }

                $code = (string)random_int(100000, 999999);

                $otp->update([
                    'token_hash'   => Hash::make($code),
                    'expires_at'   => now()->addMinutes(self::EXPIRATION_MINUTES),
                    'last_sent_at' => now(),
                    'resend_count' => $otp->resend_count + 1,
                ]);

                return [
                    'user' => $otp->user,
                    'code' => $code,
                ];
            });
        }

        public function resendAvailableIn(string $challenge): int
        {
            $otp = OtpData::query()->where('challenge_hash', hash('sha256', $challenge))->first();

            if (!$otp || !$otp->last_sent_at) {
                return 0;
            }

            $availableAt = $otp->last_sent_at->addSeconds(self::RESEND_COOLDOWN_SECONDS);

            return max(0, $availableAt->timestamp - now()->timestamp);
        }

        /**
         * Invalidate a challenge.
         */
        public function invalidate(string $challenge): void
        {
            OtpData::query()->where('challenge_hash', hash('sha256', $challenge))->delete();
        }
    }
}
