<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Project;
use App\Models\User;

class LandingYesorNoStatistics extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $dataMain = \Cache::remember('landing_yes_or_no', 3600 * 6, function() {
            $questions = array(
                "helped_placement",
                "ministry_internship",
                "helped_internship",
            );

            $dataMain = array();

            $count_string = '';

            foreach ($questions as $field) {
                $count_string .= "count(CASE WHEN $field = 1 then 1 ELSE NULL END) as $field,";
            }

            $stats = Feedback::selectRaw("$count_string count(id) as total_count")->get()->toArray()[0];

            foreach ($questions as $field) {
                $dataMain['Yes'][] = $stats[$field];
                $dataMain['No'][] = $stats['total_count'] - $stats[$field];
            }

            return $dataMain;
        });

        return response()->json($dataMain);
    }
}
