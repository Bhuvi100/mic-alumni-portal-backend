<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class CustomMail extends Mailable
{
    public string $mail_subject;
    public string $content;
    public array $data;
    public string $from_address;
    public string $from_name;
    public string|null $attachment;

    public function __construct(string $mail_subject, string $content, array $data = [],
                                string $from_address = 'innovationcell@aicte-india.org',
                                string $from_name = 'Innovation Cell, AICTE',
                                string $attachment = null)
    {
        $this->mail_subject = $mail_subject;
        $this->content = $content;
        $this->data = $data;
        $this->from_address = $from_address;
        $this->from_name = $from_name;
        $this->attachment = $attachment;
    }

    public function build()
    {
        $_ = $this->from($this->from_address, $this->from_name)
            ->subject($this->mail_subject)
            ->view('emails.custom');

        if ($this->attachment) {
            $_->attach($this->attachment);
        }

        return $_;
    }
}
