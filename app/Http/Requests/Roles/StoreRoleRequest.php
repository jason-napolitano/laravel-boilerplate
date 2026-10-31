<?php

namespace App\Http\Requests\Roles {

    use Illuminate\Foundation\Http\FormRequest;

    class StoreRoleRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return $this->user()->can('create_role');
        }

        public function rules(): array
        {
            return [
                'name' => 'required|string|unique:roles,name',
            ];
        }
    }
}
