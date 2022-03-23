<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnnouncementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'attachment' => ['nullable', 'file', 'mimes:png,jpg,jpeg,gif'],
            'status' => ['required', 'in:live,archived'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}