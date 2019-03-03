<?php

namespace App\Http\Controllers;

use App\Interfaces\MailSenderInterface;

class SendMailController extends Controller
{
	
	protected $mail_sender;

	public function __construct(MailSenderInterface $mail_sender) {
		$this->mail_sender = $mail_sender;
	}

	public function send() {
		$data = (object)[
			'to' => (object)[
				'email' => 'emilio@arcioni.com.ar',
				'name' => 'Emilio Arcioni'
			],
			'subject' => 'Este es el asunto',
			'body' => 'Este es el cuerpo del mensaje'
		];
		// $response = $this->mail_sender->sendUsingMailjet($data);

		$response = $this->mail_sender->sendUsingSendgrid($data);
		
		return response()->json($response, 200);
	}
}
