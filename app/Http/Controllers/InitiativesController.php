<?php

namespace App\Http\Controllers;

use App\Http\Requests\InitiativesRequest;
use App\Models\Initiative;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InitiativesController extends Controller
{
    public function index()
    {
        $initiatives = Initiative::latest()->get(['id', 'hackathon', 'edition', 'created_at']);

//        $initiatives = Initiative::latest()->distinct()->join('projects', 'initiatives.id', '=', 'projects.initiative_id')->join('project_user', 'projects.id', '=', 'project_user.project_id')->join('users', 'project_user.user_id', '=', 'users.id')->selectRaw(DB::raw('initiatives.id, initiatives.hackathon, initiatives.edition, initiatives.created_at, count(users.id) as users_count, count(users.signed_up_at) as registered_count'))->groupBy('initiatives.id', 'initiatives.hackathon', 'initiatives.edition', 'initiatives.created_at')->get();


//        $users_count = User::query()
//            ->selectRaw("count(users.id) as users_count,count(users.signed_up_at) as registered_count,projects.initiative_id,users.id")
//            ->join('project_user', 'users.id', '=', 'project_user.user_id')
//            ->join('projects', 'project_user.project_id', '=', 'projects.id')
//            ->groupBy('initiative_id', 'users.id')
//            ->distinct()
//            ->get();

//        $users_count = User::whereHas('projects', function ( Builder $query) use ($initiatives){
//            return $query->groupBy('projects.initiative_id')->whereIn('projects.initiative_id', $initiatives->pluck('id')->toArray());
//        })->selectRaw(DB::raw('count(id) as users_count, count(signed_up_at) as registered_count'))->get();
//
//        $initiatives->map(function ($initiative) use ($users_count) {
//            $initiative->users_count = $users_count->firstWhere('initiative_id', $initiative->id)->users_count;
//            $initiative->registered_count = $users_count->firstWhere('initiative_id', $initiative->id)->registered_count;
//        });

        return response()->json($initiatives);
    }

    public function getStats(Initiative $initiative)
    {
        $expiry = 600;

        $counts = Cache::remember("initiative_stats_{$initiative->id}", $expiry, function () use ($initiative) {
            $users_query = DB::select("SELECT DISTINCT COUNT(users.id) as users_count, SUM(case when users.signed_up_at IS NOT NULL then 1 else 0 end) as registered_count, SUM(case when ps.user_id IS NOT NULL then 1 else 0 end) as other_ideas_count, SUM(case when s.user_id IS NOT NULL then 1 else 0 end) as stories_count  FROM `users` inner join project_user pu on `users`.`id` = `pu`.`user_id` inner join projects p on `pu`.`project_id` = `p`.`id` and `p`.`initiative_id` = {$initiative->id} left join participant_status ps on users.id = ps.user_id left join stories s on users.id = s.user_id")[0];
            $projects_query = DB::select("SELECT DISTINCT count(projects.id) as projects_count, SUM(case when ps.id IS NOT NULL then 1 else 0 end) as updated_count, SUM(case when ps.funding_support_needed = 1 then 1 else 0 end) as funding_count FROM projects left join project_status ps on projects.id = ps.project_id where projects.initiative_id = {$initiative->id}")[0];
            //TODO ELIMINATE DUPLICATE COUNTS

            $r = [];

            $r['users']['users_count'] = $users_query->users_count;
            $r['users']['registered_count'] = $users_query->registered_count;
            $r['users']['other_ideas_count'] = $users_query->other_ideas_count;
            $r['users']['stories_count'] = $users_query->stories_count;

            $r['projects']['projects_count'] = $projects_query->projects_count;
            $r['projects']['updated_count'] = $projects_query->updated_count;
            $r['projects']['funding_count'] = $projects_query->funding_count;

            return  $r;
        });

        return response()->json(['users' => $counts['users'], 'projects' => $counts['projects']]);
    }

    public function store(InitiativesRequest $request)
    {
        $initiative = Initiative::create($request->validated());

        return response()->json($initiative);
    }

    public function show(Initiative $initiative)
    {
        return response()->json($initiative);
    }

    public function update(InitiativesRequest $request,Initiative $initiative)
    {
        $initiative->update($request->validated());

        return response()->json($initiative);
    }

    public function destroy(Initiative $initiative)
    {
        $initiative->delete();

        return response()->json(['success' => 1]);
    }
}