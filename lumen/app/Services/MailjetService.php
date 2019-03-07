<?php 

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \Mailjet\Resources;
use Event;
use App\Events\MailSentEvent;

class MailjetService{

	protected $mailjet;

	public function __construct(){

		$this->mailjet = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'), true, ['version' => 'v3.1']);
		$this->mailjet->setConnectionTimeout(15);
	}

	public function make($data){
		$defaults = [
			'to' => [],
			'subject' => '',
			'body' => ''
		];

		$data = array_merge($defaults, $data);


		$to = [];
		foreach($data['to'] as $t) {
			$to[] = [
				'Email' => $t['email'],
				'Name' => $t['name']
			];
		}

		$body = [
			'Messages' => [
				[
					'From' => [
						'Email' => getenv('MAIL_FROM_EMAIL'),
						'Name' => getenv('MAIL_FROM_NAME')
					],
					'To' => $to,
					'Subject' => $data['subject'],
					'TextPart' => strip_tags($data['body']),
					'HTMLPart' => $data['body']
				]
			],
			// 'SandboxMode' => true
		];
		
		$response = $this->mailjet->post(Resources::$Email, ['body' => $body]);
		$message = $response->getData()['Messages'][0];

		switch($message['Status']){
			case "success":
				$data['status_id'] = 1;
				break;
			case "error":
				$data['status_id'] = 2;
				break;
		}

		Event::fire(new MailSentEvent($data));
		
		return $message;
	}

}