<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackUpdateRequest;
use App\Models\Feedback;
use App\Models\User;

class FeedbackController extends Controller
{
    public function show(User $user)
    {
        return $user->feedback;
    }


    public function update(FeedbackUpdateRequest $request, User $user)
    {
        if ($user->feedback()->exists()) {
            $user->feedback()->update($request->validated());
        } else {
            $user->feedback()->create($request->validated());
        }

        return $user->feedback;
    }
}