<?php

namespace App\Http\Controllers;

use App\Mail\MagicLoginMail;
use App\Models\User;
use App\Services\PasswordlessLoginUrlService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->firstOrFail();

        Log::info('LOGIN TRY BY: ' . $request->email);

        $url = PasswordlessLoginUrlService::forUser($user)->generate();

        Mail::to($user)->send(new MagicLoginMail($url));

        return 'Mail sent';
    }
}