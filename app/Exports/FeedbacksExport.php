<?php

namespace App\Exports;

use App\Models\Feedback;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FeedbacksExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Feedback::with('user', 'user.projects')->get();
    }

    public function headings(): array
    {
        return [
            'user_id',
            'name',
            'email',
            'alternate_email',
            'phone',
            'gender',
            'signed_up_at',
            'initiatives',
            'project_status',
            'mic_confidence',
            'hired_by_ministry',
            'hired_by_name',
            'helped_placement',
            'placement_country',
            'placement_name',
            'ministry_internship',
            'ministry_internship_name',
            'helped_internship',
            'helped_internship_name',
            'higher_studies',
            'higher_studies_degree',
            'higher_studies_stream',
            'higher_studies_country',
            'helped_higher_studies',
            'received_award',
            'award_name',
            'award_level',
            'award_state',
            'award_country',
            'ip_registration',
            'ip_type',
            'ip_country',
            'ip_status',
            'registered_startup',
            'registered_startups_count',
            'received_investment',
            'investment_level',
            'recommend_others',
            'participation_social_awareness',
            'comments',
            'improvements',
        ];
    }

    public function map($row): array
    {
        $user = $row->user;
        $initiatives = new Collection();
        $project_status = new Collection();

        foreach ($row->user->projects as $project) {
            $initiatives->add("{$project->initiative->hackathon} - {$project->initiative->edition}");
            $status_submission = $project->project_status()->exists() ? 'yes' : 'no';
            $project_status->add("{$project->initiative->hackathon} - {$project->initiative->edition} => {$status_submission}");
            unset($project);
        }

        $initiatives_string = $initiatives->unique()->implode("\n");
        $status_string = $project_status->unique()->implode("\n");

        unset($initiatives, $project_status);

        $data = [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'alternate_email' => $user->alternate_email,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'signed_up_at' => $user->signed_up_at,
            'initiatives' => $initiatives_string,
            'project_status' => $status_string,
            'mic_confidence' => $row->mic_confidence,
            'hired_by_ministry' => $row->hired_by_ministry,
            'hired_by_name' => $row->hired_by_name,
            'helped_placement' => $row->helped_placement,
            'placement_country' => $row->placement_country,
            'placement_name' => $row->placement_name,
            'ministry_internship' => $row->ministry_internship,
            'ministry_internship_name' => $row->ministry_internship_name,
            'helped_internship' => $row->helped_internship,
            'helped_internship_name' => $row->helped_internship_name,
            'higher_studies' => $row->higher_studies,
            'higher_studies_degree' => $row->higher_studies_degree,
            'higher_studies_stream' => $row->higher_studies_stream,
            'higher_studies_country' => $row->higher_studies_country,
            'helped_higher_studies' => $row->helped_higher_studies,
            'received_award' => $row->received_award,
            'award_name' => $row->award_name,
            'award_level' => $row->award_level,
            'award_state' => $row->award_state,
            'award_country' => $row->award_country,
            'ip_registration' => $row->ip_registration,
            'ip_type' => $row->ip_type,
            'ip_country' => $row->ip_country,
            'ip_status' => $row->ip_status,
            'registered_startup' => $row->registered_startup,
            'registered_startups_count' => $row->registered_startups_count,
            'received_investment' => $row->received_investment,
            'investment_level' => $row->investment_level,
            'recommend_others' => $row->recommend_others,
            'participation_social_awareness' => $row->participation_social_awareness,
            'comments' => $row->comments,
            'improvements' => $row->improvements,
        ];

        foreach ($data as $field => $value) {
            if ($value === 1) {
                $data[$field] = 'Yes';
                continue;
            }

            if ($value === 0) {
                $data[$field] = 'No';
            }
        }

        return $data;
    }

}
