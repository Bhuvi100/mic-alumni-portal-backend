<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackUpdateRequest;
use App\Models\User;

class FeedbackController extends Controller
{
    public function show(User $user)
    {
        return response()->json($user->feedback);
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