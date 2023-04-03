<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeMakerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'url' => [ 'url', 'max:255'],
            'status' => ['required', 'in:live,archived'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
