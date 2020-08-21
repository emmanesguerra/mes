<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Core\Library\Modules\SystemConfigLibrary;

class NewsletterSignup extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $reciever = SystemConfigLibrary::retrieve('email_reciever');
        $token = $this->token;
        
        return $this->from($reciever)
                    ->subject("Newsletter Email Verification")
                    ->view('mail.newsletter.subscriber.index')->with(compact('token'));
    }
}
