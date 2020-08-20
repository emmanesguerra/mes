<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendInquiry extends Mailable
{
    use Queueable, SerializesModels;

    protected $title;
    protected $body;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($body, $title)
    {
        $this->body = $body;
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $body = $this->body;
        
        return $this->from($body->email)
                    ->subject($this->title)
                    ->view('mail.contactus.index')->with(compact('body'));
    }
}
