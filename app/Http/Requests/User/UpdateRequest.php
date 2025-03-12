<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
        $userId = $this->user()->id;

        return [
            'first_name' => ["nullable", "string"],
            'last_name' => ["nullable", "string"],
            'middle_name' => ["nullable", "string"],
            'username' => ["nullable", "max:255", "unique:users,username,{$userId}"],
            'email' => ["nullable", "string", "email", "max:255", "unique:users,email,{$userId}"],
            'phone' => ["nullable", "string", "regex:/^\+?\d{1,14}$/", "unique:users,phone,{$userId}"],
        ];
    }
}
