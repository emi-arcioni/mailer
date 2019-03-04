<?php

namespace App\Http\Controllers;

use App\Interfaces\MailSenderInterface;
use Illuminate\Http\Request;
use App\Http\Requests\SendMailRequest;

class SendMailController extends Controller
{
	
	protected $mail_sender;
	protected $validate;

	public function __construct(
		MailSenderInterface $mail_sender,
		SendMailRequest $validate
	) {
		$this->mail_sender = $mail_sender;
		$this->validate = $validate;
	}

	public function send(Request $request) {

		$this->validate->send($request->all());
		$response = $this->doSend($request->input());

		return $response;
	}

	public function doSend($data) {
		$response = $this->mail_sender->sendUsingMailjet($data);
		
		if ($response['Status'] == 'error') {
			$response = $this->mail_sender->sendUsingSendgrid($data);
			if ($response == 202) {
				return response()->json(['message' => 'The mail was sent to ' . $data['to']['email']], 200);		
			}
		} else {
			return response()->json(['message' => 'The mail was sent to ' . $data['to']['email']], 200);	
		}		
		
		
	}

	/*public function sendWithDefaults() {
		$data = [
			'to' => [
				'email' => 'emilio@arcioni.com.ar',
				'name' => 'Emilio Arcioni'
			],
			'subject' => 'Este es el asunto',
			'body' => 'Este es el cuerpo del mensaje'
		];

		return $this->doSend($data);
	}*/
}
