<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'phone' => ['required', 'string', 'min:10', 'max:25'],
            'gender' => ['required', 'in:male,female,other']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}