<?php

namespace App\Http\Requests\SuperAdminUserRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SuperAdminUpdateUserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($this->user)],
            'account_type' => 'sometimes|required|string',
            'phone' => 'sometimes|nullable|string',
            'password' => 'sometimes|required|string|min:8',
        ];
    }
}
