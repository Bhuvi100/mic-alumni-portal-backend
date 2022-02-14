<?php

namespace App\Services;

use Grosv\LaravelPasswordlessLogin\LoginUrl;
use Grosv\LaravelPasswordlessLogin\PasswordlessLoginService;
use Illuminate\Contracts\Auth\Authenticatable as User;
use Illuminate\Support\Facades\URL;

class PasswordlessLoginUrlService {
    /**
     * @var User
     */
    private User $user;
    /**
     * @var string
     */
    protected string $route_name;
    /**
     * @var \Carbon\Carbon
     */
    protected \Carbon\Carbon $route_expires;

    public function __construct(User $user)
    {
        $this->user = $user;

        $this->route_expires = now()->addMinutes($this->user->login_route_expires_in ?? config('laravel-passwordless-login.login_route_expires'));

        $this->route_name = config('laravel-passwordless-login.login_route_name');
    }

    public static function forUser(User $user)
    {
        return new self($user);
    }

    public function generate()
    {
        return URL::temporarySignedRoute(
            $this->route_name,
            $this->route_expires,
            [
                'email' => $this->user->email,
                'hash' => sha1($this->user->email),
            ]
        );
    }
}