<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function __invoke()
    {
        $expiry = 600;

        $top_counts = Cache::remember('top_counts', $expiry, function () {
            $query = DB::select("SELECT 'projects' as type, COUNT(id) as count from projects UNION
                          SELECT 'patents' as type, COUNT(id) as count from projects WHERE exists (select * from project_status where project_status.project_id = projects.id and project_status.is_patent_registered = 1) UNION
                          SELECT 'startups' as type, COUNT(id) as count from projects WHERE exists (select * from project_status where project_status.project_id = projects.id and project_status.startup_status = 1) UNION
                          SELECT 'users' as type, COUNT(id) as count from users where role = 'user' UNION 
                          SELECT 'users_registered' as type, COUNT(id) as count from users where role = 'user' and signed_up_at is not null UNION
                          SELECT 'feedbacks' as feedbacks, COUNT(id) as count from feedbacks UNION
                          SELECT 'other_ideas' as other_ideas, COUNT(id) as count from participant_status                                            
                          ");

            $r = [];
            foreach ($query as $q) {
                $r[$q->type] = $q->count;
            }

            return  $r;
        });

        $users_gender_count = Cache::remember('users_gender_count', $expiry, function () {
            $query = User::select(['gender', DB::raw('count(*) as count')])->groupBy('gender')->get();

            $r = [];
            foreach ($query as $q) {
                $r[$q->gender] = $q->count;
            }

            return  $r;
        });

        $signup_count = Cache::remember('signup_count', $expiry, function () {
            $query = User::select(DB::raw('MONTHNAME(signed_up_at) as month,COUNT(id) as count'))->where('signed_up_at', '>', now()->subMonths(5)->firstOfMonth())->oldest('signed_up_at')->groupby('month')->get()->all();

            $r = [];
            foreach ($query as $q) {
                $r[$q->month] = $q->count;
            }

            return  $r;
        });

        return response()->json(compact('top_counts', 'users_gender_count', 'signup_count'));
    }
}
