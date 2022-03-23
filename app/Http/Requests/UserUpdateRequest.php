<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'alternate_email' => ['nullable', 'email'],
            'phone' => ['required', 'digits:10, 15', 'numeric'],
            'gender' => ['required', 'in:male,female,other'],
            'picture' => ['sometimes', 'nullable', 'file', 'mimes:jpg,jpeg,png']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}