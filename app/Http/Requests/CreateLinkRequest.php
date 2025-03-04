<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateLinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
        ];
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user does not exist in our records.',
        ];
    }
}
