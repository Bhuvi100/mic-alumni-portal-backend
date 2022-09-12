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
            'confirm_attended' => ['required', 'boolean'],
            'nodal_center' => ['nullable', 'required_if:confirm_attended,1', 'string'],
            'days_attended' => ['nullable', 'required_if:confirm_attended,1', 'numeric', 'min:1', 'max:5'],
            'role' => ['nullable', 'required_if:confirm_attended,1', 'string', 'in:Evaluator,Mentor,Design Expert'],
            'video_link' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png'],
            'feedback' => ['nullable', 'required_if:confirm_attended,1', 'string']
        ]);

        if (!auth()->user()->mentorWillingness()->exists()) {
            return abort(403);
        }

        $willingness = auth()->user()->mentorWillingness()->firstWhere('hackathon', 'SIH 2022');

        if (!$willingness || !$willingness->interested || !$willingness->is_selected) {
            return abort(401);
        }

        $feedback = $willingness->feedback()->updateOrCreate(['mentor_id' => $willingness->id], $request->except('image'));

        if ($request->hasFile('image')) {
            if ($feedback->image && \Storage::exists($feedback->image)) {
                \Storage::delete($feedback->image);
            }

            $feedback->image = $request->file('image')->store('images/feedback');
            $feedback->save();
        }

        $willingness->load('feedback');

        return response()->json($willingness);
    }

    public function show(?User $user)
    {
        $user = $user?->id ? $user : auth()->user();

        return response()
            ->json($user->mentorWillingness()->with('feedback')->where('hackathon', 'SIH 2022')->first() ?? []);
    }
}
