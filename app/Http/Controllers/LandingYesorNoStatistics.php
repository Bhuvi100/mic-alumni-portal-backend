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
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $questions = array(
            "hired_by_ministry",
            "helped_placement",
            "ministry_internship",
            "helped_internship",
            "higher_studies",
            "received_award",
            "ip_registration",
            "registered_startup",
            "received_investment",
            );
            $options = array(
                1,
                0,
                "Yes",
                "No"   
            );

            $dataMain = array();
            for($i=1;$i<=2;$i++){
                $dataMain[$options[$i+1]]= array(
                    Feedback::where($questions[0], '=', $options[$i-1])->get()->count(),
                    Feedback::where($questions[1], '=', $options[$i-1])->get()->count(),
                    Feedback::where($questions[2], '=', $options[$i-1])->get()->count(),
                    Feedback::where($questions[3], '=', $options[$i-1])->get()->count(),
                    Feedback::where($questions[4], '=', $options[$i-1])->get()->count(),
                    Feedback::where($questions[5], '=', $options[$i-1])->get()->count(),
                    Feedback::where($questions[6], '=', $options[$i-1])->get()->count(),
                    Feedback::where($questions[7], '=', $options[$i-1])->get()->count(),
                    Feedback::where($questions[8], '=', $options[$i-1])->get()->count(),
                   
                );
            }
        return response()->json($dataMain);
    }
}
