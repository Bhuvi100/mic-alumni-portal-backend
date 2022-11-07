<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\UserUpdateRequest;
use App\Jobs\UsersExportJob;
use App\Mail\UserExportMail;
use App\Models\User;
use Illuminate\Container\Container;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Paginate the given query.
     *
     * @param  int|null  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate($query, $perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $query->model->getPerPage();

        $total = User::filter()->distinct()->count('users.id');

        $results = ($total)
            ? $query->forPage($page, $perPage)->get($columns)
            : $query->model->newCollection();

        return $this->paginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items', 'total', 'perPage', 'currentPage', 'options'
        ));
    }

    public function index()
    {
        $query = User::filter();

        return response()->json($this->paginate($query, 25, 'users.*'));
    }

    public function exportData()
    {
        UsersExportJob::dispatch(auth()->user(), request()->all());

        return response()->json(['status' => 'success']);

    }


    public function show(?User $user)
    {
        $user = $user->id ? $user : auth()->user();
        $user_array = $user->toArray();
        $user_array['roles'] = $user->roles;
        $user_array['expertise'] = $user->expertise;

        $w = auth()->user()->mentorWillingness->where('hackathon','UIA 2022')->first();
        $user_array['is_uia_willing'] = !($w?->interested === false);
        $user_array['mentor_willingness_filled'] = $w && $w->theme;


        return response()->json([
            'user' => $user_array,
            'projects' => $user->projects()->with('initiative')->get()
                ->mapWithKeys(function($project) {
                    $array = [
                        'id' => $project->id,
                        'team_name' => $project->team_name,
                        'title' => $project->title,
                        'description' => $project->description,
                        'ps_title' => $project->ps_title,
                        'college' => $project->college,
                        'leader_id' => $project->leader_id,
                        'initiative' => [
                            'hackathon' => $project->initiative->hackathon,
                            'edition' => $project->initiative->edition
                        ]
                    ];

                    return [$project->id => $array];
                }),
            'own_projects' => $user->status()->get()->mapWithKeys(function ($project) {
                $array = [
                    'project_title' => $project->project_title,
                    'project_theme' => $project->project_theme,
                    'project_status' => $project->project_status,
                    'project_ip_generated' => $project->project_ip_generated,
                    'project_ip_type' => $project->project_ip_type,
                    'project_ip_status' => $project->project_ip_status,
                    'project_image' => $project->project_image,
                    'project_incubated' => $project->project_incubated,
                    'project_incubator_name' => $project->project_incubator_name,
                    'project_incubator_city' => $project->project_incubator_city,
                    'project_hackathon_related' => $project->project_hackathon_related,
                    'project_funding_support' => $project->project_funding_support,
                    'project_trl_level' => $project->project_trl_level,
                    'project_video_url' => $project->project_video_url,
                ];

                return [$project->id => $array];
            })
        ]);
    }

    public function update(UserUpdateRequest $request)
    {
        $user = auth()->user();

        $data = $request->except(['roles', 'expertise']);

        if (!$user->signed_up_at) {
            $data['signed_up_at'] = now();
        }

        if ($request->hasFile('picture')) {
            if ($user->getRawOriginal('picture') != null && Storage::disk('public')->exists($user->getRawOriginal('picture'))) {
                Storage::disk('public')->delete($user->getRawOriginal('picture'));
            }

            $data['picture'] = $request->file('picture')->store('images/users', 'public');
        }

        $data['roles_and_expertise'] = [
            'roles' => $request->get('roles', []),
            'expertise' => $request->get('expertise', []),
        ];

        $user->update($data);

        $user_array = $user->toArray();
        $user_array['roles'] = $user->roles;
        $user_array['expertise'] = $user->expertise;
        return response()->json([
            'success' => 1,
            'user' => $user_array,
        ]);
    }
}
