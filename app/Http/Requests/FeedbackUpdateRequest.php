<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hired_by_ministry' => ['required', 'boolean'],
            'hired_by_ministry_elaborate' => ['required_if:hired_by_ministry,1', 'string'],
            'opportunity_status' => ['required', 'boolean'],
            'opportunity_details' => ['required_if:opportunity_status,1', 'string'],
            'recommendation_status' => ['required', 'boolean'],
            'recommendation_details' => ['required_if:recommendation_status,1', 'string'],
            'mic_help' => ['required', 'boolean'],
            'recommend_to_student' => ['required', 'boolean'],
            'mic_participation' => ['required', 'boolean'],
            'comments' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}