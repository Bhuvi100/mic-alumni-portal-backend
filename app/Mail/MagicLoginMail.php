<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class MagicLoginMail extends Mailable
{
    public string $login_url;

    public function __construct(string $login_url)
    {
        $this->login_url = $login_url;
    }

    public function build()
    {
        return $this->from('innovationcell@aicte-india.org', 'Innovation Cell, AICTE')->view('emails.magic-login');
    }
}