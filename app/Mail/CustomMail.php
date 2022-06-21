<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class CustomMail extends Mailable
{
    public string $mail_subject;
    public string $content;
    public array $data;

    public function __construct(string $mail_subject, string $content, array $data = [])
    {
        $this->mail_subject = $mail_subject;
        $this->content = $content;
        $this->data = $data;
    }

    public function build()
    {
        return $this->from('innovationcell@aicte-india.org', 'Innovation Cell, AICTE')
            ->subject($this->mail_subject)
            ->view('emails.custom');
    }
}
