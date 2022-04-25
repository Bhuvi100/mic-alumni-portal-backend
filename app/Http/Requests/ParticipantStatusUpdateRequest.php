<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParticipantStatusUpdateRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $inputs = $this->all();

        foreach ($inputs as $field => $input) {
            if ($input == '' || $input == 'null' || $input == 'undefined') {
                $inputs[$field] = null;
            }
        }

        $this->merge($inputs);
    }

    public function rules(): array
    {
        return [
            'project_title' => ['required', 'nullable', 'string'],
            'project_theme' => ['required', 'nullable', 'string'],
            'project_status' => ['required', 'nullable', 'string'],
            'project_ip_generated' => ['required', 'nullable', 'boolean'],
            'project_ip_type' => ['required_if:project_ip_generated,1', 'nullable', 'string'],
            'project_ip_status' => ['required_if:project_ip_generated,1', 'nullable', 'boolean'],
            'project_image' => [Rule::requiredIf(\Illuminate\Support\Facades\Route::currentRouteName() === 'status.store'), 'file', 'image'],
            'project_incubated' => ['required', 'boolean'],
            'project_incubator_name' => ['required_if:project_incubated,1', 'string', 'nullable'],
            'project_incubator_city' => ['required_if:project_incubated,1', 'string', 'nullable'],
            'project_hackathon_related' => ['required', 'nullable', 'boolean'],
            'project_funding_support' => ['required', 'nullable', 'boolean'],
            'project_trl_level' => ['required', 'nullable', 'string'],
            'project_video_url' => ['required', 'nullable', 'url'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}