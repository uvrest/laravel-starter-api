<?php

namespace App\Http\Requests\UserAuthRequest;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $this->user()->id,
            'password' => 'sometimes|required|string|confirmed',
            'account_type' => 'sometimes|required|string|in:admin,manager,moderator',
            'phone' => 'nullable|string',
        ];
    }
}
