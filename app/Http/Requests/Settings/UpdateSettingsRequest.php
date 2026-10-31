<?php

namespace App\Http\Requests\Settings {

    use App\Enums\ItemsPerPage;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rule;

    class UpdateSettingsRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return $this->user()->can('update_settings');
        }

        public function rules(): array
        {
            return [
                'title'                 => ['sometimes', 'string', 'max:55'],
                'description'           => ['sometimes', 'string', 'max:500'],
                'version'               => ['sometimes', 'string'],
                'items_per_page'        => ['sometimes', 'integer', Rule::enum(ItemsPerPage::class)],
                'enable_passkeys'       => ['sometimes', 'boolean'],
                'enable_reset_password' => ['sometimes', 'boolean'],
                'enable_registration'   => ['sometimes', 'boolean'],
            ];
        }
    }
}
