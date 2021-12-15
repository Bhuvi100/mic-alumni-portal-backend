<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParticipantStatusUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_status' => ['required', 'string'],
            'project_prototype' => ['required', 'boolean'],
            'project_title' => ['required_if:project_prototype,1', 'string'],
            'project_theme' => ['required_if:project_prototype,1', 'string'],
            'project_status' => ['required_if:project_prototype,1', 'string'],
            'project_ip_generated' => ['required_if:project_prototype,1', 'boolean'],
            'project_ip_type' => [Rule::requiredIf($this->project_prototype == 1 && $this->project_ip_generated), 'string'],
            'project_ip_status' => [Rule::requiredIf($this->project_prototype == 1 && $this->project_ip_generated), 'boolean'],
            'project_hackathon_related' => ['required_if:project_prototype,1', 'boolean'],
            'project_funding_support' => ['required_if:project_prototype,1', 'boolean'],
            'project_trl_level' => ['required_if:project_prototype,1', 'string'],
            'project_video_url' => ['required_if:project_prototype,1', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}