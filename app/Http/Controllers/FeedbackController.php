<?php

namespace App\Http\Controllers;

use App\Exports\FeedbacksExport;
use App\Http\Requests\FeedbackUpdateRequest;
use App\Models\Feedback;
use App\Models\Project;
use App\Models\User;
use Maatwebsite\Excel\Excel;

class FeedbackController extends Controller
{
    public function index()
    {
        return response()->json(Feedback::latest()->select(['id', 'user_id', 'ip_registration', 'registered_startup', 'received_investment', 'received_award', 'recommend_others'])->with('user:id,name,email,phone')->paginate(15));
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

    public function export()
    {
        return \Excel::download(new FeedbacksExport(), 'feedbacks.xlsx', Excel::CSV);
    }
}
