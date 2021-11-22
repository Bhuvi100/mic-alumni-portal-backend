<?php

namespace App\Imports;

use App\Models\Import;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Events\BeforeImport;

class DataImport implements ToCollection, WithHeadingRow, WithChunkReading, ShouldQueue, withEvents
{
    use RegistersEventListeners;
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $rows = array_change_key_case($rows->toArray(), CASE_LOWER);

        $projects = 0;
        $users = 0;

        foreach ($rows as $row) {
            //Creating Leader user
            $data = [];

            foreach ($this->leader_mapping() as $column => $header) {
                $data[$column] = $row[$header];
            }

            if (!in_array($data['gender'], $this->genders(), true)) {
                $data['gender'] = 'na';
            }

            if (!$leader = User::firstWhere('email', $data['email'])) {
                $leader = User::create($data);
                $users ++;
            }

            //Creating Project
            $data = [];

            foreach ($this->project_mapping() as $column => $header) {
                $data[$column] = $row[$header];
            }

            if (Str::length($data['ps_title']) > 255) {
                $data['ps_title'] = substr($data['ps_title'], 0, 255);
            }

            $project = $leader->projects_as_leader()->firstOrCreate($data);

            $leader->projects()->attach($project);

            if ($project->wasRecentlyCreated) {
                $projects ++;
            }


            //Creating members
            for ($id = 2; $id < 7; $id++) {
                $data = [];

                foreach ($this->members_mapping($id) as $column => $header) {
                    $data[$column] = $row[$header];
                }

                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    break;
                }

                if (!in_array($data['gender'], $this->genders(), true)) {
                    $data['gender'] = 'na';
                }

                if ($user = User::firstWhere('email', $data['email'])) {
                   $project->users()->attach($user);
                } else {
                    $project->users()->create($data);
                    $users++;
                }
            }
        }

        $import = Import::latest()->first();
        $import->update(['projects' => (int)($import->projects) + $projects, 'users' => (int)($import->users) + $users]);
    }

    private function genders()
    {
        return [
            'male',
            'female',
            'other'
        ];
    }

    private function leader_mapping()
    {
        return [
            'name' => 'leader_name',
            'email' => 'emailid',
            'phone' => 'leader_phone',
            'gender' => 'leader_gender'
        ];
    }

    private function project_mapping()
    {
        return [
            'year' => 'year',
            'team_name' => 'team_name',
            'type' => 'type',
            'theme' => 'theme',
            'ministry/organisation' => 'ministryorganisation',
            'title' => 'idea_title',
            'description' => 'idea_description',
            'ps_title' => 'ps_title',
            'ps_description' => 'ps_description',
            'ps_code' => 'ps_code',
            'ps_id' => 'ps_id',
            'idea_id/team_id' => 'idea_idteam_id',
            'college' => 'college',
            'college_state' => 'college_state',
        ];
    }

    private function members_mapping(int $id)
    {
        return [
          'name' => "member_{$id}_name",
            'email' => "member_{$id}_email",
            'phone' => "member_{$id}_contact",
            'gender' => "member_{$id}_gender",
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public static function beforeImport(BeforeImport $event)
    {
        Import::latest()->first()->update(['status' => 'P']);
    }

    public static function afterImport(AfterImport $event)
    {
        Import::latest()->first()->update(['status' => 'C']);
    }
}
