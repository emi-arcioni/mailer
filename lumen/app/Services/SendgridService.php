<?php 

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \SendGrid\Mail\Mail;
use Event;
use App\Events\MailSentEvent;

class SendgridService{

	protected $sendgrid;

	public function __construct(){

		$this->sendgrid = new Mail();
		$this->sendgrid->setFrom(getenv('MAIL_FROM_EMAIL'), getenv('MAIL_FROM_NAME'));

	}

	public function make($data) {
		$this->sendgrid->setSubject($data['subject']);
		foreach($data['to'] as $to) {
			$this->sendgrid->addTo($to['email'], $to['name']);
		}
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

		Event::fire(new MailSentEvent($data));

		return $response->statusCode();
	}

}