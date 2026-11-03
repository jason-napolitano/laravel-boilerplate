<?php

namespace App\Models {

    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    /**
     * @property $challenge_hash
     * @property $last_sent_at
     * @property $resend_count
     * @property $verified_at
     * @property $expires_at
     * @property $token_hash
     * @property $attempts
     * @property $user_id
     * @property $user
     */
    class OtpData extends BaseModel
    {
        protected $table = 'otp_data';

        protected $fillable = [
            'challenge_hash',
            'resend_count',
            'last_sent_at',
            'verified_at',
            'expires_at',
            'token_hash',
            'attempts',
            'user_id',
        ];

        protected function casts(): array
        {
            return [
                'last_sent_at' => 'datetime',
                'verified_at'  => 'datetime',
                'expires_at'   => 'datetime',
                'resend_count' => 'integer',
                'attempts'     => 'integer',
            ];
        }

        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }
    }
}
