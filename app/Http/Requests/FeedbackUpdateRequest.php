<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FeedbackUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mic_confidence' => ['required', 'in:Strongly Agree,Agree,May be,Disagree,Strongly Disagree'],
            'hired_by_ministry' => ['required', 'boolean'],
            'hired_by_name' => ['required_if:hired_by_ministry,1', 'nullable', 'string'],
            'helped_placement' => ['required', 'boolean'],
            'placement_country' => ['required_if:helped_placement,1', 'nullable', 'string', 'in:India,Abroad'],
            'placement_name' => ['required_if:helped_placement,1', 'nullable', 'string'],
            'ministry_internship' => ['required', 'boolean'],
            'ministry_internship_name'  => ['required_if:ministry_internship,1', 'nullable', 'string'],
            'helped_internship' => ['required', 'boolean'],
            'helped_internship_name'  => ['required_if:helped_internship,1', 'nullable', 'string'],
            'higher_studies' => ['required', 'boolean'],
            'higher_studies_degree' => ['required_if:higher_studies,1', 'nullable', 'string', 'in:Master,PhD,Others'],
            'higher_studies_stream' => ['required_if:higher_studies,1', 'nullable', 'string'],
            'higher_studies_country' => ['required_if:higher_studies,1', 'nullable', 'string', 'in:India,Abroad'],
            'helped_higher_studies' => ['required', 'in:Strongly Agree,Agree,May be,Disagree,Strongly Disagree'],
            'received_award' => ['required', 'boolean'],
            'award_name' => ['required_if:received_award,1', 'nullable', 'string'],
            'award_level' => ['required_if:received_award,1', 'nullable', 'string', 'in:State Level,National Level,International Level'],
            'award_state' => ['required_if:award_level,State Level', 'nullable', 'string'],
            'award_country' => ['required_if:award_level,International Level', 'nullable', 'string'],
            'ip_registration' => ['required', 'boolean'],
            'ip_type' => ['required_if:ip_registration,1', 'nullable', 'string', 'in:Patent,Copy Right,Trademark'],
            'ip_country' => ['required_if:ip_registration,1', 'nullable', 'string', 'in:India,Foreign'],
            'ip_status' => ['required_if:ip_registration,1', 'nullable', 'string', 'in:Applied,Filed,Granted,Register'],
            'registered_startup' => ['required', 'boolean'],
            'registered_startups_count' => ['required_if:registered_startup,1', 'numeric', 'min:1'],
            'received_investment' => ['required', 'boolean'],
            'investment_level' => ['required_if:received_investment,1', 'nullable', 'string', 'in:Up to 10 Lakh,Up to 25 Lakh,Up to 50 Lakh,1 Crore,Greater than 1 Crore'],
            'recommend_others'  => ['required', 'in:Strongly Agree,Agree,May be,Disagree,Strongly Disagree'],
            'participation_social_awareness' => ['required', 'in:Strongly Agree,Agree,May be,Disagree,Strongly Disagree'],
            'comments' => ['required', 'string'],
            'improvements' => ['required', 'string'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}