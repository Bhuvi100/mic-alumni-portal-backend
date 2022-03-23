<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InitiativesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hackathon' => ['required', 'string'],
            'edition' => ['required', 'string']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}