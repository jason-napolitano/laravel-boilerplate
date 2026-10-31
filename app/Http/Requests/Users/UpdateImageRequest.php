<?php

namespace App\Http\Requests\Users {

    use Illuminate\Foundation\Http\FormRequest;

    class UpdateImageRequest extends FormRequest
    {
        public function authorize(): bool
        {
            return $this->user()->can('updateImage', $this->route('user'));
        }

        public function rules(): array
        {
            return [
                'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:8196'],
            ];
        }
    }
}
