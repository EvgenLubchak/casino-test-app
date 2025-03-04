<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|string|max:255',
            'phone' => 'required|digits_between:10,15|unique:users,phone', // Unique phone validation

        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'The username field is required.',
            'username.string'   => 'The username must be a valid string.',
            'username.max'      => 'The username may not be greater than 255 characters.',
            'phone.required' => 'The phone number is required.',
            'phone.digits_between' => 'The phone number must be between 10 and 15 digits.',
            'phone.unique' => 'This phone number is already registered.',

        ];
    }
}
