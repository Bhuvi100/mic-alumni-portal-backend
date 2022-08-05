<?php

namespace App\Http\Controllers;

use App\Models\MentorWillingness;
use App\Models\User;
use Illuminate\Http\Request;
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
        ]);

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
