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
use function Symfony\Component\Translation\t;

class UsersExportJob implements ShouldQueue
{
    use Dispatchable,InteractsWithQueue,Queueable,SerializesModels;

    public User $user;
    public array $filter;
    public bool $withMentorWillingness = false;

    public function __construct(User $user, array $filter)
    {
        $this->user = $user;
        $this->filter = $filter;
        $this->withMentorWillingness = (bool)request()->get('mentor_willingness');
    }

    public  function usersGenerator() {
        $query = User::filter($this->filter)->distinct()
            ->with(['projects.initiative:id,hackathon,edition'])
            ->select('users.*');

        if ($this->withMentorWillingness) {
            $query->with('mentorWillingnessSih2022')
                ->whereRelation('mentorWillingness','hackathon', '=', 'SIH 2023');
        }

        foreach ($query->lazy(1000) as $user) {
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
            $startup_exists = false;

            foreach ($user->projects->load('project_status:id,project_id') as $project) {
                $initiatives[] = "{$project->initiative->hackathon} - {$project->initiative->edition}";
                $status = $project->project_status;
                $status_submission = $status ? 'yes' : 'no';
                $project_status[] = "{$project->initiative->hackathon} - {$project->initiative->edition} => {$status_submission}";

                if ($status?->startup_status) {
                    $startup_exists = true;
                }
            }

            $college = $user->projects()->latest()->first()->college;

            if (!$startup_exists && $user->feedback?->registered_startup) {
                $startup_exists = true;
            } else {
                foreach ($user->status ?? [] as $own_idea) {
                    if ($own_idea->project_incubated) {
                        $startup_exists = true;
                    }
                }
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
                'college' => $college,
                'signed_up_at' => $user->signed_up_at,
                'employment_status' => $user->employment_status,
                'degree' => $user->degree,
                'organization_name' => $user->organization_name,
                'designation' => $user->designation,
                'initiatives' => $initiatives_string,
                'project_status' => $status_string,
                'feedback' => $user->feedback()->exists() ? 'yes' : 'no',
                'participant_status' => $user->status()->exists() ? 'yes' : 'no',
                'has_startup' => $startup_exists ? 'yes' : 'no',
            ];

            unset($initiatives_string, $status_string);

            if ($this->withMentorWillingness) {
                $mentorWillingness = $user->mentorWillingness()->firstWhere('hackathon', 'SIH 2023');
                $data['category'] = $mentorWillingness->category;
                $data['nodal_center'] = $mentorWillingness->nodal_center;
                $data['designation'] = $mentorWillingness->designation;
                $data['organization_name'] = $mentorWillingness->organization_name;
                $data['state'] = $mentorWillingness->state;
                $data['city'] = $mentorWillingness->city;
                $data['participated_in_previous'] = $mentorWillingness->participated_in_previous;
                $data['cv'] = $mentorWillingness->cv;
            }

            return $data;
        });

        Mail::to($this->user)->send(new UserExportMail($file));
    }
}
