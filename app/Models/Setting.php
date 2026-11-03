<?php

namespace App\Models {

    /**
     * @property bool $enable_reset_password
     * @property bool $enable_registration
     * @property bool $enable_otp_support
     * @property bool $enable_passkeys
     * @property int $items_per_page
     * @property string $description
     * @property string $version
     * @property string $title
     * @property string $logo
     */
    class Setting extends BaseModel
    {
        protected $fillable = [
            'enable_reset_password',
            'enable_registration',
            'enable_otp_support',
            'enable_passkeys',
            'items_per_page',
            'description',
            'version',
            'title',
            'logo',
        ];

        protected function casts(): array
        {
            return [
                'enable_reset_password' => 'boolean',
                'enable_registration'   => 'boolean',
                'enable_otp_support'    => 'boolean',
                'enable_passkeys'       => 'boolean',
                'items_per_page'        => 'integer',
                'enable_2fa'            => 'boolean',
            ];
        }
    }
}
