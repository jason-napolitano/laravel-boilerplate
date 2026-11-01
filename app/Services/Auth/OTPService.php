<?php

namespace App\Services\Auth {


    use App\Models\OtpData;
    use App\Models\User;
    use Illuminate\Support;

    class OTPService
    {
        public const int EXPIRATION_MINUTES = 5;

        public const int MAX_ATTEMPTS = 5;

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
                'expires_at'     => now()->addMinutes(
                    self::EXPIRATION_MINUTES
                ),
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

        /**
         * Invalidate a challenge.
         */
        public function invalidate(string $challenge): void
        {
            OtpData::query()->where('challenge_hash', hash('sha256', $challenge))->delete();
        }
    }
}
