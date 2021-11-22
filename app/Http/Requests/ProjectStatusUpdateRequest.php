<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStatusUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'development_status' => ['required', 'boolean'],
            'description' => ['required_if:development_status,1', 'string'],
            'mic_support' => ['required_if:development_status,0', 'boolean'],
            'fund_status' => ['required', 'boolean'],
            'fund_organisation'  => ['required_if:fund_status,1', 'string'],
            'fund_amount'  => ['required_if:fund_status,1', 'string'],
            'funding_date'  => ['required_if:fund_status,1', 'date'],
            'funding_support_needed'  => ['required_if:fund_status,0', 'boolean'],
            'project_delivery_status' => ['required', 'boolean'],
            'project_delivered_status' => ['required_if:project_delivery_status,1', 'string'],
            'project_implemented_by_ministry' => ['required_if:project_delivery_status,1', 'boolean'],
            'incubator_status' => ['required', 'boolean'],
            'name_of_incubator' => ['required_if:incubator_status,1', 'string'],
            'trl_level' => ['required', 'string'],
            'video_url' => ['required', 'string'],
            'ip_status' => ['required', 'boolean'],
            'ip_type' => ['required_if:ip_status,1', 'string'],
            'is_patent_registered' => ['required_if:ip_status,1', 'boolean'],
            'ip_number' => ['required_if:ip_status,1', 'string'],
            'date_of_ip_reg' => ['required_if:ip_status,1', 'date'],
            'number_of_ip_filed_till_date' => ['required_if:ip_status,1', 'string'],
            'startup_status' => ['required', 'boolean'],
            'startup_name' => ['required_if:startup_status,1', 'string'],
            'company_registration_status' => ['required', 'boolean'],
            'company_name' => ['required_if:company_registration_status,1', 'string'],
            'company_cin' => ['required_if:company_registration_status,1', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}