<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        $user['project_id'] = auth()->user()->projects->first()?->id;

        return ['user' => $user];
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $data = $request->validated();

        if (!$user->signed_up_at) {
            $data['signed_up_at'] = now();
        }

        $user->update($data);

        return [
            'success' => 1,
            'user' => $user
        ];
    }

    public function destroy($id)
    {
        //
    }
}