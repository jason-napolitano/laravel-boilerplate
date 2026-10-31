<?php

namespace App\Http\Requests\Permissions {

    use Illuminate\Foundation\Http\FormRequest;

    class StorePermissionRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return $this->user()->can('create_permission');
        }

        public function rules(): array
        {
            return [
                'name' => ['required', 'string'],
            ];
        }
    }
}
