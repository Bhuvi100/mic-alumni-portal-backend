<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        $query = User::filter();

        return response()->json($query->paginate(25, 'users.*'));
    }

    public function exportData()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }


    public function show(?User $user)
    {
        $user = $user->id ? $user : auth()->user();

        return response()->json([
            'user' => $user,
            'projects' => $user->projects()->get()
                ->mapWithKeys(function($project) {
                    $array = [
                        'id' => $project->id,
                        'team_name' => $project->team_name,
                        'title' => $project->title,
                        'initiative' => [
                            'hackathon' => $project->initiative->hackathon,
                            'edition' => $project->initiative->edition
                        ]
                    ];

                    return [$project['id'] => $array];
                }),
        ]);
    }

    public function update(UserUpdateRequest $request)
    {
        $user = auth()->user();

        $data = $request->validated();

        if (!$user->signed_up_at) {
            $data['signed_up_at'] = now();
        }

        if ($request->hasFile('picture')) {
            if ($user->getRawOriginal('picture') != null && Storage::disk('public')->exists($user->getRawOriginal('picture'))) {
                Storage::disk('public')->delete($user->getRawOriginal('picture'));
            }

            $data['picture'] = $request->file('picture')->store('images/users', 'public');
        }

        $user->update($data);

        return response()->json([
            'success' => 1,
            'user' => $user,
        ]);
    }
}