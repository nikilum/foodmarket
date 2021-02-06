<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailVerify extends Mailable
{
    use Queueable, SerializesModels;

    protected $verify;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verify)
    {
        $this->verify = $verify;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.email_verify')->with([
            'verify_code' => $this->verify['verify_code']
        ]);
    }
}
