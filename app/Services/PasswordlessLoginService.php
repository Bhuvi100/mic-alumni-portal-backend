<?php

namespace App\Services;

use Grosv\LaravelPasswordlessLogin\PasswordlessLoginService as BaseService;
use Illuminate\Support\Facades\Auth;

class PasswordlessLoginService extends BaseService {
    /**
     * Get the user from the request.
     *
     * @return mixed
     */
    public function getUser()
    {
        return Auth::guard(config('laravel-passwordless-login.user_guard'))
            ->getProvider()
            ->retrieveByCredentials(['email' => request('email')]);
    }
}