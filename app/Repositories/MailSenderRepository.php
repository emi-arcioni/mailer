<?php 

namespace App\Repositories;

use App\Interfaces\MailSenderInterface;
use App\Services\MailjetService;
use App\Services\SendgridService;
use Illuminate\Http\Request;

class MailSenderRepository implements MailSenderInterface{
	
	protected $mail_jet;
	protected $send_grid;
	
	public function __construct(
		MailjetService $mail_jet,
		SendgridService $send_grid
	){
		$this->mail_jet = $mail_jet;
		$this->send_grid = $send_grid;
	}
	
	public function sendUsingMailjet($data){
		return $this->mail_jet->make($data);
	}

	public function sendUsingSendgrid($data){
		return $this->send_grid->make($data);
	}
   
}