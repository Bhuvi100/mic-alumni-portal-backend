<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectStatusUpdateRequest;
use App\Models\Project;

class ProjectStatusController extends Controller
{
    public function show(Project $project)
    {
        authorize_action($project);

        return response()->json($project->project_status);
    }


    public function update(ProjectStatusUpdateRequest $request, Project $project)
    {
        authorize_action($project);

        if ($project->project_status()->exists()) {
            $logo = $project->project_status->company_logo;

            if ($request->hasFile('company_logo')) {
                if ($logo && \Storage::exists($logo)) {
                    \Storage::delete($logo);
                }

                $logo = $request->file('company_logo')->store('images/company_logos');
            }

            $project->project_status()->update($request->except('company_logo') + ['company_logo' => $logo]);
        } else {
            $logo = null;
            if ($request->hasFile('company_logo')) {
                $logo = $request->file('company_logo')->store('images/company_logos');
            }

            $project->project_status()->create($request->except('company_logo') + ['company_logo' => $logo]);
        }

        return response()->json($project->project_status);
    }
}