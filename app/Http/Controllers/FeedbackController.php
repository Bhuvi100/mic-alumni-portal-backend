<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackUpdateRequest;
use App\Models\Project;
use App\Models\User;

class FeedbackController extends Controller
{
    public function show(Project $project, ?User $user)
    {
        authorize_action($project, $user);

        return response()->json($user->id ?
            $user->feedback()->firstWhere('project_id', $project->id) :
            $project->feedbackOfAuthUser());
    }


    public function update(FeedbackUpdateRequest $request, Project $project)
    {
        authorize_action($project);

        $feedback = $project->feedbackOfAuthUser();

        if ($feedback) {
            $feedback->update($request->validated());
        } else {
            $feedback = $project->feedbacks()->create($request->validated() + ['user_id' => auth()->id()]);
        }

        return $feedback;
    }
}