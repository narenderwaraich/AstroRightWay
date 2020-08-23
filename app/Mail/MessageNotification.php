<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
   public $user;
   public $chatData;

    public function __construct($user,$chatData)
    {
        $this->user = $user;
        $this->chatData = $chatData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $userName = $this->user['name']; 
        $subject = $userName.' '."Sent New Message";
        return $this->from('info@astrorightway.com')->subject($subject)->view('email.Message-notification');
    }
}
