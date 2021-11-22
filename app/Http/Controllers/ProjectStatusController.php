<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStatusUpdateRequest;
use App\Models\Project;

class ProjectStatusController extends Controller
{
    public function show(Project $project)
    {
        return $project->project_status;
    }


    public function update(ProjectStatusUpdateRequest $request, Project $project)
    {
        if ($project->project_status()->exists()) {
            $project->project_status()->update($request->validated());
        } else {
            $project->project_status()->create($request->validated());
        }

        return $project->project_status;
    }
}