<?php

namespace App\Http\Controllers;

use Grosv\LaravelPasswordlessLogin\Exceptions\ExpiredSignatureException;
use Grosv\LaravelPasswordlessLogin\Exceptions\InvalidSignatureException;
use Grosv\LaravelPasswordlessLogin\LaravelPasswordlessLoginController;
use App\Services\PasswordlessLoginService;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Auth;

class ValidateLoginController extends Controller
{
    /**
     * @var PasswordlessLoginService
     */
    private PasswordlessLoginService $passwordlessLoginService;

    /**
     * @var UrlGenerator
     */
    private UrlGenerator $urlGenerator;

    /**
     *
     * @param PasswordlessLoginService $passwordlessLoginService
     */
    public function __construct(PasswordlessLoginService $passwordlessLoginService, UrlGenerator $urlGenerator)
    {
        $this->passwordlessLoginService = $passwordlessLoginService;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Handles login from the signed route.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Psr\SimpleCache\InvalidArgumentException|InvalidSignatureException|ExpiredSignatureException
     */
    public function login(Request $request)
    {
        if (!$this->urlGenerator->hasCorrectSignature($request) ||
            ($this->urlGenerator->signatureHasNotExpired($request) && !$this->passwordlessLoginService->requestIsNew())) {
            throw new InvalidSignatureException();
        } else if (!$this->urlGenerator->signatureHasNotExpired($request)) {
            throw new ExpiredSignatureException();
        }

        $this->passwordlessLoginService->cacheRequest($request);

        $user = $this->passwordlessLoginService->user;

        $redirectUrl = env('FRONTEND_DOMAIN') . config('laravel-passwordless-login.redirect_on_success');

        $token = $user->createToken('magic_link_login')->plainTextToken;

        return redirect("$redirectUrl?token=$token");
    }
}