<?php 

namespace App\Repositories;

use App\Interfaces\MailSenderInterface;
use App\Services\MailjetService;
use Illuminate\Http\Request;

class MailSenderRepository implements MailSenderInterface{
	
	protected $mail_jet;
	
	public function __construct(
		MailjetService $mail_jet
	){
		$this->mail_jet = $mail_jet;
	}
	
	public function sendUsingMailjet($data){
		return $this->mail_jet->make($data);
	}

	public function sendUsingSendgrid(){
		// return $this->index_company->make();
	}
   
}