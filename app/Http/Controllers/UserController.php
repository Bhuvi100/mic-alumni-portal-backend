<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $query = User::query();
        $filter_registered = \request()->get('registered', null);

        if ($filter_registered) {
            $query->whereNotNull('signed_up_at');
        } else if ($filter_registered !== null) {
            $query->whereNull('signed_up_at');
        }

        if (\request()->get('bootstrapped', false)) {
            $query->whereHas('projects', function (Builder $builder) {
                $builder->whereRelation('project_status', 'startup_status', true);
            });
        }

        if (\request()->get('funding', false) == true) {
            $query->whereHas('projects', function (Builder $builder) {
                $builder->whereRelation('project_status', 'funding_support_needed', true);
            });
        }

        if (($initiatives = \Request::get('initiatives', [])) && (count($initiatives))) {
            $query->whereHas('projects',function (Builder $builder) use ($initiatives) {
                $builder->whereIn('initiative_id',$initiatives);
            });
        }

        return response()->json($query->paginate(25));
    }


    public function show(?User $user)
    {
        $user = $user->id ? $user : auth()->user();

        return response()->json([
            'user' => $user,
            'projects' => $user->projects()->get()
                ->mapWithKeys(function($project) {
                    $array = [
                        'id' => $project->id,
                        'team_name' => $project->team_name,
                        'title' => $project->title,
                        'initiative' => [
                            'hackathon' => $project->initiative->hackathon,
                            'edition' => $project->initiative->edition
                        ]
                    ];

                    return [$project['id'] => $array];
                }),
        ]);
    }

    public function update(UserUpdateRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        if (!$user->signed_up_at) {
            $data['signed_up_at'] = now();
        }

        if ($request->hasFile('picture')) {
            if ($user->getRawOriginal('picture') != null && Storage::disk('public')->exists($user->getRawOriginal('picture'))) {
                Storage::disk('public')->delete($user->getRawOriginal('picture'));
            }

            $data['picture'] = $request->file('picture')->store('images/users', 'public');
        }

        $user->update($data);

        return response()->json([
            'success' => 1,
            'user' => $user,
        ]);
    }
}