<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->subject = "Hello!";
        $this->content = "Hi, " . $user->name . "!<br>Your BULSCA account has been created!";
        $this->action_url = "ff";
        $this->action_text = "Click here to log in";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@bulsca.co.uk', 'BULSCA')->subject($this->subject)->view('mail.mail-template', ['subject' => $this->subject, 'content' => $this->content, 'action_url' => $this->action_url, 'action_text' => $this->action_text]);
    }
}
