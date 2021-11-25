<?php

namespace App\Http\Controllers;

use App\Mail\MagicLoginMail;
use App\Models\User;
use Grosv\LaravelPasswordlessLogin\PasswordlessLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        $url = PasswordlessLogin::forUser($user)->generate();

        $url = str_replace('http://127.0.0.1:8000', 'https://samwyc.ga', $url);

        Mail::to($user)->send(new MagicLoginMail($url));

        return 'Mail sent';
    }
}