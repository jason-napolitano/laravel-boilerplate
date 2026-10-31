<?php

namespace App\Http\Requests\Users {

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rules\Password;
    use Illuminate\Validation\Rule;

    class UpdateUserRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return $this->user()->can('update', $this->route('user'));
        }

        public function rules(): array
        {
            $user = $this->route('user');

            return [
                'email'     => ['nullable', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
                'username'  => ['nullable', 'string', Rule::unique('users')->ignore($user)],
                'password'  => ['sometimes', Password::defaults(), 'confirmed'],
                'name'      => ['nullable', 'string', 'max:255'],
                'biography' => ['nullable', 'string', 'max:1250'],
            ];
        }
    }
}
