<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $queryName = $this->query['name']; 
        $subject = $queryName.' '."new Query";
        return $this->from('info@astrorightway.com')->subject($subject)->view('email.Contact-us');
    }
}
