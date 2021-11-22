<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParticipantStatusUpdateRequest;
use App\Models\User;

class ParticipantStatusesController extends Controller
{
    public function show(User $user)
    {
        return $user->feedback;
    }


    public function update(ParticipantStatusUpdateRequest $request, User $user)
    {
        if ($user->status()->exists()) {
            $user->status()->update($request->validated());
        } else {
            $user->status()->create($request->validated());
        }

        return $user->feedback;
    }
}