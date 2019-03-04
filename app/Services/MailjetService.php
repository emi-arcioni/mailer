<?php 

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \Mailjet\Resources;
use App\Services\LogDeliveryService;

class MailjetService{

	protected $mailjet;
	protected $log_delivery_service;

	public function __construct(LogDeliveryService $log_delivery_service){

		$this->log_delivery_service = $log_delivery_service;

		$this->mailjet = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'), true, ['version' => 'v3.1']);
		$this->mailjet->setConnectionTimeout(15);
	}

	public function make($data){
		$body = [
			'Messages' => [
				[
					'From' => [
						'Email' => getenv('MAIL_FROM_EMAIL'),
						'Name' => getenv('MAIL_FROM_NAME')
					],
					'To' => [
						[
							'Email' => $data['to']['email'],
							'Name' => $data['to']['name']
						]
					],
					'Subject' => $data['subject'],
					'TextPart' => $data['body']
				]
			],
			'SandboxMode' => true
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

		$this->log_delivery_service->make($data);
		
		return $message;
	}

}