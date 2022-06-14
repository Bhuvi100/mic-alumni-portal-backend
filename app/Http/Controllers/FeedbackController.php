<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackUpdateRequest;
use App\Models\Feedback;
use App\Models\Project;
use App\Models\User;

class FeedbackController extends Controller
{
    public function index()
    {
        return response()->json(Feedback::latest()->select(['id', 'user_id', 'ip_registration', 'registered_startup', 'received_investment'])->with('user:id,name,email')->paginate(15));
    }

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
