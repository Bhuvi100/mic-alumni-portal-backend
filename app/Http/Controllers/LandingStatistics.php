<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Project;
use App\Models\User;

class LandingStatistics extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {    $questions = array(
                    'mic_confidence',
                    'helped_higher_studies',
                    'recommend_others',
                    'participation_social_awareness',
                    );
         $options = array(
            'Agree',
            'Strongly Agree',
            'Maybe',
            'Disagree',
            'Strongly Disagree',
         );

        $dataMain = array();
        for($i=1;$i<=5;$i++){
            $dataMain[$options[$i-1]]= array(
                Feedback::where($questions[0], '=', $options[$i-1])->get()->count(),
                Feedback::where($questions[1], '=', $options[$i-1])->get()->count(),
                Feedback::where($questions[2], '=', $options[$i-1])->get()->count(),
                Feedback::where($questions[3], '=', $options[$i-1])->get()->count(),
                
            );
        }
        /*
        for($i=0;$i<=3;$i++){
           
           $dataMain[$i] = array(
            'agree'=>Feedback::where($questions[$i], '=', 'Agree')->get()->count(),
            'stronglyAgree'=>Feedback::where($questions[$i], '=', 'Strongly Agree')->get()->count(),
            'maybe'=> Feedback::where($questions[$i], '=', 'Maybe')->get()->count(),
            'disagree'=>Feedback::where($questions[$i], '=', 'Disagree')->get()->count(),
            'stronglyDisagree'=> Feedback::where($questions[$i], '=', 'Strongly Disagree')->get()->count(),
            );
         }
         */

        return response()->json($dataMain);
        
    }
}
