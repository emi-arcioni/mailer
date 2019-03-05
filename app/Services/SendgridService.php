<?php 

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \SendGrid\Mail\Mail;
use App\Services\LogDeliveryService;

class SendgridService{

	protected $sendgrid;
	protected $log_delivery_service;

	public function __construct(LogDeliveryService $log_delivery_service){

		$this->log_delivery_service = $log_delivery_service;

		$this->sendgrid = new Mail();
		$this->sendgrid->setFrom(getenv('MAIL_FROM_EMAIL'), getenv('MAIL_FROM_NAME'));

	}

	public function make($data) {
		$this->sendgrid->setSubject($data['subject']);
		$this->sendgrid->addTo($data['to']['email'], $data['to']['name']);
		$this->sendgrid->addContent("text/plain", strip_tags($data['body']));
		$this->sendgrid->addContent("text/html", $data['body']);

		$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

		try {
			$response = $sendgrid->send($this->sendgrid);
		} catch (Exception $e) {
			echo 'Caught exception: '. $e->getMessage() ."\n";
		}
		
		switch($response->statusCode()){
			case 202:
				$data['status_id'] = 1;
				break;
			case 401:
				$data['status_id'] = 2;
				break;
		}

		$this->log_delivery_service->make($data);

		return $response->statusCode();
	}

}