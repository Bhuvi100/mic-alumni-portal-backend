<?php

namespace App\Http\Controllers;

use App\Models\MentorWillingness;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MentorWillingnessesController extends Controller
{
    public function store(Request $request)
    {
       $willingness = auth()->user()->mentorWillingness()->firstOrCreate(['hackathon' => 'UIA 2022'], ['interested' => true]);

        $request->validate([
            'theme' => ['required', 'string', 'max:255'],
            'expertise' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'organization_name' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'cv' => ['nullable', Rule::requiredIf(!($willingness->cv && Storage::exists($willingness->cv))), 'file', 'mimes:pdf,doc,docx'],
            'participated_in_previous' => ['required', 'boolean']
        ]);

        $willingness->update($request->except('cv'));

        if ($request->hasFile('cv')) {
            if ($willingness->cv && \Storage::exists($willingness->cv)) {
                \Storage::delete($willingness->cv);
            }

            $willingness->cv = $request->file('cv')->store('willingness/uia/cv');
            $willingness->save();
        }

        return response()->json($willingness);
    }

    public function show(?User $user)
    {
        $user = $user?->id ? $user : auth()->user();

        return response()
            ->json($user->mentorWillingness()->firstWhere('hackathon', 'UIA 2022') ?? []);
    }
}
