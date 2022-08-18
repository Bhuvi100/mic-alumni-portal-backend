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
            'is_accepted' => ['required', 'boolean'],
        ]);

        if (!auth()->user()->mentorWillingness()->exists()) {
            return abort(403);
        }

        $willingness = auth()->user()->mentorWillingness()->firstWhere('hackathon', 'SIH 2022');

        if (!$willingness || !$willingness->interested || !$willingness->is_selected || $willingness->is_accepted !== null) {
            return abort(401);
        }

        $willingness->update(['is_accepted' => $request->is_accepted]);

        return response()->json($willingness);
    }

    public function show(?User $user)
    {
        $user = $user?->id ? $user : auth()->user();

        return response()
            ->json($user->mentorWillingness->where('hackathon', 'SIH 2022')->first() ?? []);
    }
}
