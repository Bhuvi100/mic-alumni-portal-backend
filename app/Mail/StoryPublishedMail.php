<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class StoryPublishedMail extends Mailable
{
    public string $story_url;

    public function __construct(string $story_url)
    {
        $this->story_url = $story_url;
    }

    public function build()
    {
        return $this->from('innovationcell@aicte-india.org', 'Innovation Cell, AICTE')
            ->subject("Congratulations, your success story got published!")
            ->view('emails.story-published');
    }
}
