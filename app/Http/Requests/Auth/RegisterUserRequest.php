<?php

namespace App\Http\Requests\Auth {

    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Validation\Rules\Password;
    use App\Models\User;

    class RegisterUserRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return true;
        }

        public function rules(): array
        {
            return [
                'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Password::defaults()],
                'username' => ['required', 'string', 'unique:users'],
                'name'     => ['required', 'string', 'max:255'],
            ];
        }
    }
}
