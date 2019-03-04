<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Validator;

class SendMailRequest{

	private function render($data, $rules) {

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) {
			$error = $validator->failed();
			$data = array('inputs' => $error);
			abort(400, json_encode($data));
		}

	}

	public function send($data) {

		$rules = [
			'to.email' => 'required|email',
			'to.name' => 'required|string',
			'subject' => 'required|max:255|string',
			'body' => 'required'
		];

		$this->render($data, $rules);
	}

}