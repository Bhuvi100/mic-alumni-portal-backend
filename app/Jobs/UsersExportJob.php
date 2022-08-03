<?php

namespace App\Jobs;

use App\Mail\UserExportMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class UsersExportJob implements ShouldQueue
{
    use Dispatchable,InteractsWithQueue,Queueable,SerializesModels;

    public User $user;
    public array $filter;

    public function __construct(User $user, array $filter)
    {
        $this->user = $user;
        $this->filter = $filter;
    }

    public  function usersGenerator() {
        foreach (User::filter($this->filter)->distinct()
                     ->with(['projects.initiative:id,hackathon,edition'])
                     ->select('users.*')->lazy(1000) as $user) {
            yield $user;
        }
    }

    /**
     * @throws \OpenSpout\Common\Exception\IOException
     * @throws \OpenSpout\Writer\Exception\WriterNotOpenedException
     * @throws \OpenSpout\Common\Exception\UnsupportedTypeException
     * @throws \OpenSpout\Common\Exception\InvalidArgumentException
     */
    public function handle()
    {
        $file = (new FastExcel($this->usersGenerator()))->export(Storage::disk('local')->path('users.xlsx'), function ($user) {
            $initiatives = [];
            $project_status = [];

            foreach ($user->projects->load('project_status:id,project_id') as $project) {
                $initiatives[] = "{$project->initiative->hackathon} - {$project->initiative->edition}";
                $status_submission = $project->project_status?->first() ? 'yes' : 'no';
                $project_status[] = "{$project->initiative->hackathon} - {$project->initiative->edition} => {$status_submission}";
            }

            $initiatives_string = implode("\n", array_unique($initiatives));
            $status_string = implode("\n", array_unique($project_status));

            unset($initiatives, $project_status, $status_submission);

            $data = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'alternate_email' => $user->alternate_email,
                'phone' => $user->phone,
                'gender' => $user->gender,
                'signed_up_at' => $user->signed_up_at,
                'initiatives' => $initiatives_string,
                'project_status' => $status_string,
                'feedback' => $user->feedback()->exists() ? 'yes' : 'no',
                'participant_status' => $user->status()->exists() ? 'yes' : 'no',
            ];

            unset($initiatives_string, $status_string);

            return $data;
        });

        Mail::to($this->user)->send(new UserExportMail($file));
    }
}
