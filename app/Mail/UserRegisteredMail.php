<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegisteredMail extends Mailable
{
	use Queueable, SerializesModels;

	private $user;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$name = $this->user->name;
		
		return $this
			->subject("Usuário $name acabou de registrar!")
			->markdown('emails.user-registered', ['user' => $this->user]);
	}
}
