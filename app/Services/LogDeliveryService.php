<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LogDeliveryService {

	public function __construct(){

	}

	public function make($data) {

		$delivery = DB::table('deliveries')->insert([
			'email_to' => $data['to']['email'],
			'name_to' => $data['to']['name'],
			'subject' => $data['subject'],
			'body' => $data['body'],
			'status_id' => $data['status_id'],
			'created_at' => new \DateTime()
		]);

		return $delivery;
	}
	
}