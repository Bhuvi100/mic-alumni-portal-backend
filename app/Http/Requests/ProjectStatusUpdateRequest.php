<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStatusUpdateRequest extends FormRequest
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
            'development_status' => ['required', 'boolean'],
            'description' => ['required_if:development_status,1', 'nullable','string'],
            'mic_support' => ['required_if:development_status,0', 'nullable','boolean'],
            'fund_status' => ['required', 'boolean'],
            'fund_organisation'  => ['required_if:fund_status,1', 'nullable','string'],
            'fund_amount'  => ['required_if:fund_status,1', 'nullable','string'],
            'funding_date'  => ['required_if:fund_status,1', 'nullable','date'],
            'funding_support_needed'  => ['required_if:fund_status,0', 'nullable','boolean'],
            'project_delivery_status' => ['required', 'boolean'],
            'project_delivered_status' => ['required_if:project_delivery_status,1', 'nullable','string'],
            'project_implemented_by_ministry' => ['required_if:project_delivery_status,1', 'nullable','boolean'],
            'mic_support_deploy' => ['required_if:project_delivery_status,0', 'nullable','boolean'],
            'incubator_status' => ['required', 'boolean'],
            'name_of_incubator' => ['required_if:incubator_status,1', 'nullable','string'],
            'trl_level' => ['required', 'string'],
            'video_url' => ['required', 'url'],
            'ip_status' => ['required', 'boolean'],
            'ip_type' => ['required_if:ip_status,1', 'nullable','string'],
            'is_patent_registered' => ['required_if:ip_status,1', 'nullable','boolean'],
            'ip_number' => ['required_if:ip_status,1', 'nullable','string'],
            'date_of_ip_reg' => ['required_if:ip_status,1', 'nullable','date'],
            'number_of_ip_filed_till_date' => ['required_if:ip_status,1', 'nullable', 'string'],
            'startup_status' => ['required', 'boolean'],
            'startup_name' => ['required_if:startup_status,1', 'nullable','string'],
            'company_registration_status' => ['required', 'boolean'],
            'company_name' => ['required_if:company_registration_status,1', 'nullable','string'],
            'company_registration_type' => ['required_if:company_registration_status,1', 'nullable', 'string',
                'in:Section 8 Company,Private entity,As Society (Registration Act 1860),As Trust'],
            'company_registration_dpiit' => ['required_if:company_registration_status,1', 'nullable', 'boolean'],
            'company_logo' => ['nullable', 'file', 'image']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return ['company_cin' => 'Company Identification Number'];
    }

    public function messages()
    {
        return ['company_cin.required_if' => 'Company Identification field is required'];
    }
}