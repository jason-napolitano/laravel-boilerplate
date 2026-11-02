<?php

namespace App\Models {

    use Illuminate\Database\Eloquent\Relations\BelongsTo;


    class OtpData extends BaseModel
    {
        protected $table = 'otp_data';

        protected $fillable = [
            'user_id',
            'token_hash',
            'challenge_hash',
            'attempts',
            'expires_at',
            'verified_at',
        ];

        protected function casts(): array
        {
            return [
                'attempts'    => 'integer',
                'expires_at'  => 'datetime',
                'verified_at' => 'datetime',
            ];
        }

        public function user(): BelongsTo
        {
            return $this->belongsTo(User::class);
        }
    }
}
