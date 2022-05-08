<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipantStatusUpdateRequest;
use App\Models\ParticipantStatus;
use App\Models\User;

class ParticipantStatusesController extends Controller
{
    public function index() {
        return auth()->user()->status()->get()->mapWithKeys(function ($project) {
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
        });
    }

    public function show(?User $user)
    {
        return response()->json($user->id ? $user->status : auth()->user()->status);
    }

    public function store(ParticipantStatusUpdateRequest $request) {
        $image = $request->file('project_image')->store('images/own_ideas');

        return response()->json(auth()->user()->status()->create($request->except('project_image') + ['project_image' => $image]));
    }

    public function update(ParticipantStatusUpdateRequest $request, ParticipantStatus $status)
    {
        $image = $status->project_image;
        if ($request->hasFile('project_image')) {
            if (\Storage::exists($image)) {
                \Storage::delete($image);
            }

            $image = $request->file('project_image')->store('images/own_ideas');
        }

        $status->update($request->except('project_image') + ['project_image' => $image]);

        return $status;
    }
}