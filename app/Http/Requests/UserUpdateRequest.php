<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $inputs = $this->all();

        foreach ($inputs as $field => $input) {
            if ($input == '' || $input == 'null' || $input == 'undefined') {
                $inputs[$field] = null;
            }
        }

        if ($inputs['roles'] ?? false) {
            $inputs['roles'] = explode(',', $inputs['roles']);
        }

        if ($inputs['expertise'] ?? false) {
            $inputs['expertise'] = explode(',', $inputs['expertise']);
        }

        $this->merge($inputs);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'alternate_email' => ['nullable', 'email'],
            'phone' => ['required', 'digits:10, 15', 'numeric'],
            'gender' => ['required', 'in:male,female,other'],
            'picture' => ['sometimes', 'nullable', 'file', 'mimes:jpg,jpeg,png'],
            'employment_status' => ['required', 'in:Self employed,Salaried Individual'],
            'degree' => ['required', 'in:UG,PG,Ph.D'],
            'organization_name' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'roles' => ['required', 'array'],
            'expertise' => ['required', 'array']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
