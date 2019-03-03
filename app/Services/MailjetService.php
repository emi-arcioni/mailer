<?php 

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \Mailjet\Resources;

class MailjetService{

	protected $mailjet;

	public function __construct(){

		$this->mailjet = new \Mailjet\Client(getenv('MJ_APIKEY_PUBLIC'), getenv('MJ_APIKEY_PRIVATE'), true, ['version' => 'v3.1']);
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
							'Email' => $data->to->email,
							'Name' => $data->to->name
						]
					],
					'Subject' => $data->subject,
					'TextPart' => $data->body
				]
			],
			'SandboxMode' => true
		];
		// TODO: error resolver to catch ConnectException
		$response = $this->mailjet->post(Resources::$Email, ['body' => $body]);
		$message = $response->getData()['Messages'][0];
		
		return $message;
	}

}