<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteLogoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update_app_logo');
    }

    public function rules(): array
    {
        return [
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:8196'],
        ];
    }
}
