<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipantStatusUpdateRequest;
use App\Models\User;

class ParticipantStatusesController extends Controller
{
    public function show(?User $user)
    {
        return response()->json($user->id ? $user->status : auth()->user()->status);
    }


    public function update(ParticipantStatusUpdateRequest $request)
    {
        $user = auth()->user();

        if ($user->status()->exists()) {
            $user->status()->update($request->validated());
        } else {
            $user->status()->create($request->validated());
        }

        return $user->status;
    }
}