<?php 

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \SendGrid\Mail\Mail;

class SendgridService{

	protected $sendgrid;

	public function __construct(){
		$this->sendgrid = new Mail();
		$this->sendgrid->setFrom(getenv('MAIL_FROM_EMAIL'), getenv('MAIL_FROM_NAME'));

	}

	public function make($data) {
		$this->sendgrid->setSubject($data->subject);
		$this->sendgrid->addTo($data->to->email, $data->to->name);
		$this->sendgrid->addContent("text/plain", $data->body);

		$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));

		try {
			$response = $sendgrid->send($this->sendgrid);
		} catch (Exception $e) {
			echo 'Caught exception: '. $e->getMessage() ."\n";
		}

		return $response->statusCode();
	}

}