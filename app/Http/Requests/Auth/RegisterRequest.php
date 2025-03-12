<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ["required", "string"],
            'last_name' => ["required", "string"],
            'middle_name' => ["nullable", "string"],
            'username' => ["nullable", "max:255", "unique:users,username", "required_without_all:email,phone"],
            'email' => ["nullable", "string", "email", "max:255", "unique:users,email", "required_without_all:username,phone"],
            'phone' => ["nullable", "string", "regex:/^\+?\d{1,14}$/", "unique:users,phone", "required_without_all:username,email"],
            'password' => ["required", "string", "min:8"],
        ];
    }
}
