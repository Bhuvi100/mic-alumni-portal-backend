<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Iterator;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromIterator;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomChunkSize;

class UsersExport implements FromQuery, WithMapping, WithHeadings, WithCustomChunkSize
{
    use Exportable;

    /**
     * @returns Builder
     */
    public function itertor()
    {
//        return User::filter()->with('projects.initiative')->select('users.*');'//
        return User::whereNotNull('signed_up_at')->get();
    }

    public function headings(): array
    {
//        return [
//            'id',
//            'name',
//            'email',
//            'alternate_email',
//            'phone',
//            'gender',
//            'signed_up_at',
//            'initiatives',
//            'project_status',
//            'feedback',
//            'participant_status'
//        ];


        return [
            'name',
            'email',
            'phone',
            'sih_participation',
        ];
    }

    public function map($user): array
    {
//        $initiatives = new Collection();
//        $project_status = new Collection();
//
//        foreach ($user->projects as $project) {
//            $initiatives->add("{$project->initiative->hackathon} - {$project->initiative->edition}");
//            $status_submission = $project->project_status()->exists() ? 'yes' : 'no';
//            $project_status->add("{$project->initiative->hackathon} - {$project->initiative->edition} => {$status_submission}");
//        }

//        return [
//            'id' => $user->id,
//            'name' => $user->name,
//            'email' => $user->email,
//            'alternate_email' => $user->alternate_email,
//            'phone' => $user->phone,
//            'gender' => $user->gender,
//            'signed_up_at' => $user->signed_up_at,
////            'initiatives' => $initiatives->unique()->implode("\n"),
////            'project_status' => $project_status->unique()->implode("\n"),
////            'feedback' => $user->feedback()->exists() ? 'yes' : 'no',
////            'participant_status' => $user->status()->exists() ? 'yes' : 'no',
//        ];

        $initiatives = new Collection();

        foreach ($user->projects as $project) {
            $initiatives->add("{$project->initiative->hackathon} - {$project->initiative->edition}");
        }
        return [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'sih_participation' => $initiatives->unique()->implode("\n"),
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function query()
    {
        return User::whereNull('signed_up_at');
    }
}
