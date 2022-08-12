<?php

namespace App\Http\Controllers;

use App\Models\MentorWillingness;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class MentorWillingnessesController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'interested' => ['required', 'boolean'],
            'category' => ['nullable', 'required_if:interested,1', 'in:sw,hw'],
            'nodal_center' => ['nullable', 'required_if:interested,1', Rule::in(array_keys(MentorWillingness::$nodal_centers))],
            'associate' => ['nullable', 'required_if:interested,1', 'in:Evaluator,Mentor,Design Expert'],
            'city' => ['nullable', 'required_if:interested,1', 'string'],
            'state' => ['nullable', 'required_if:interested,1', 'string']
        ]);

        if (!auth()->user()->mentorWillingness()->exists() && $request->interested == 1) {
            $user = auth()->user();

            Mail::to($user)->queue(new \App\Mail\CustomMail("Smart India Hackathon 2022 Evaluator Consent Received",
                "<p>Greetings {{ \$name}},</p>

<p>Your application for participating in Smart India Hackathon, 2022 has been accepted.</p> 
<p>The selection of evaluators is based on the alumnus' profile and the availability of nodal centers nearby to the alumnus' current location. Kindly update your profile by 16th August, 2022 if you haven't already.</p>
<p> The date, transport facility, accommodation and further information regarding the hackathon will be notified on or before the end of next week ( 18th August, 2022 ) via email. If you don't receive a mail by the end of next week, then your application is not considered for the current hackathon.</p>
<p>This may occur due to lack of vacancies for evaluators, as our alumni strength is a large count, also we do our best to bring maximum participation.</p>
<p>If you have any queries or need more information, please reach out to https://www.sih.gov.in or send us mail at micalumni@aicte-india.org.</p>
<p>Thank you!</p>

<br><br>
<p>    With Regards,<br>    MoE's Innovation Cell,<br>    All India Council for Technical Education (AICTE),<br>    Nelson Mandela Marg, VasantKunj,<br>    New Delhi-110070.<br>    011-29581316</p>",
                ['name' => $user->name], 'micalumni@aicte-india.org', 'Alumni Portal, MoE\'s Innovation Cell'));
        }

        $willingness = auth()->user()->mentorWillingness()->updateOrCreate(['hackathon' => 'SIH 2022'], $request->all());

        return response()->json($willingness);
    }

    public function show(?User $user)
    {
        $user = $user?->id ? $user : auth()->user();

        return response()
            ->json($user->mentorWillingness->where('hackathon', 'SIH 2022')->first() ?? []);
    }
}
