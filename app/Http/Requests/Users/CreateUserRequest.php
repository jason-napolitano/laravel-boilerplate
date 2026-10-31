<?php

namespace App\Http\Requests\Users {

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rules\Password;

    class CreateUserRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return $this->user()->can('create_user');
        }

        public function rules(): array
        {
            return [
                'email'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
                'password'  => ['required', 'confirmed', Password::defaults()],
                'username'  => ['required', 'string', 'unique:users'],
                'name'      => ['required', 'string', 'max:255'],
                'role_id'   => ['required', 'integer', 'exists:roles,id'],
                'biography' => ['nullable', 'string', 'max:500'],
            ];
        }
    }
}
