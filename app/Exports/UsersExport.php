<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::filter()->with('projects.initiative')->get('users.*');
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'email',
            'alternate_email',
            'phone',
            'gender',
            'signed_up_at',
            'initiatives',
            'project_status',
            'feedback',
            'participant_status'
        ];
    }

    public function map($user): array
    {
        $initiatives = new Collection;
        $project_status = new Collection();
        $feedback = new Collection();

        foreach ($user->projects as $project) {
            $initiatives->add("{$project->initiative->hackathon} - {$project->initiative->edition}");
            $status_submission = $project->project_status()->exists() ? 'yes' : 'no';
            $project_status->add("{$project->initiative->hackathon} - {$project->initiative->edition} => {$status_submission}");
            $feedback_submission = $project->feedbackOfUser($user) ? 'yes' : 'no';
            $feedback->add("{$project->initiative->hackathon} - {$project->initiative->edition} => {$feedback_submission}");
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'alternate_email' => $user->alternate_email,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'signed_up_at' => $user->signed_up_at,
            'initiatives' => $initiatives->unique()->implode("\n"),
            'project_status' => $project_status->unique()->implode("\n"),
            'feedback' => $feedback->unique()->implode("\n"),
            'participant_status' => $user->status()->exists() ? 'yes' : 'no',
        ];
    }
}
