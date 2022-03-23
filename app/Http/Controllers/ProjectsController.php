<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProjectsController extends Controller
{
    public function index(?User $user)
    {
        $user = $user->id ? $user : auth()->user();
        return response()->json($user->projects()
            ->get()
            ->mapWithKeys(function($project) {
                $array = $project->get(['projects.id', 'team_name', 'title'])->toArray()[0];
                $array['initiative'] =  $project->initiative->get(['hackathon', 'edition'])[0];

                return [$project['id'] => $array];
            }));
    }
}