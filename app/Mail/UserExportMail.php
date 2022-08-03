<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserExportMail extends Mailable implements ShouldQueue
{
    use Queueable,SerializesModels;

    public string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function build()
    {
        return $this->view('emails.user-export')
            ->subject('Users Data')
            ->attach($this->file);
    }
}
