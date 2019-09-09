<?php

namespace App\Mail;

use App\Token;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewAffiliateTokenMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;

	/**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Token $token)
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
        return $this->markdown('emails.new-affiliate-token', ['token' => $this->token]);
    }
}
