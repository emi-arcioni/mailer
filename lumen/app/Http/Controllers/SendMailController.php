<?php

namespace App\Http\Controllers;

use App\Interfaces\MailSenderInterface;
use Illuminate\Http\Request;
use App\Http\Requests\SendMailRequest;
use App\Jobs\SendMail;
use Queue;

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
		return $this->queue($request->input());
	}

	public function queue($data) {
		Queue::push(new SendMail($this, $data));

		return;
	}

	public function doSend($data) {
		$response = $this->mail_sender->sendUsingMailjet($data);
		
		if ($response['Status'] == 'error') {
			$response = $this->mail_sender->sendUsingSendgrid($data);
			if ($response == 202) {
				return $this->response(array_column($data['to'], 'email'));
			}
		} else {
			return $this->response(array_column($data['to'], 'email'));
		}
		
	}

	private function response($email, $status = 200) {
		return response()->json(['message' => 'The mail was sent to ' . join($email, ", ")], $status);
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
