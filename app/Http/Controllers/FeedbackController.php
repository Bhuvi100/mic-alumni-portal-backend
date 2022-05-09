<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackUpdateRequest;
use App\Models\Project;
use App\Models\User;

class FeedbackController extends Controller
{
    public function show(?User $user)
    {
        $user = $user->id ? $user : auth()->user();

        authorize_action($user);

        return response()->json($user->feedback);
    }


    public function update(FeedbackUpdateRequest $request)
    {
        $user = auth()->user();

        if ($user->feedback()->exists()) {
            $user->feedback->update($request->validated());
        } else {
            $user->feedback()->create($request->validated());
        }

        return response()->json($user->feedback);
    }
}