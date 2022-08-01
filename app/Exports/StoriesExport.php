<?php

namespace App\Exports;

use App\Models\Feedback;
use App\Models\Story;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StoriesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Story::with('user', 'user.projects')->get();
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
            'title',
            'description',
            'display',
            'archive',
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

        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'alternate_email' => $user->alternate_email,
            'phone' => $user->phone,
            'gender' => $user->gender,
            'signed_up_at' => $user->signed_up_at,
            'initiatives' => $initiatives_string,
            'project_status' => $status_string,
            'title' => $row->title ,
            'description' => $row->description ,
            'display' => $row->display ,
            'archive' => $row->archive === 1 ? 'Yes' : 'No',
        ];
    }

}
