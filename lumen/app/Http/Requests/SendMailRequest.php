<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Validator;

Validator::extend('numericarray', function($attribute, $value, $parameters){
    foreach($value as $k => $v) {
         if(!is_int($k)) return false;
    }
    return true;
});

class SendMailRequest{

	private function render($data, $rules) {

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) {
			$error = $validator->failed();
			abort(400, json_encode($error));
		}

	}

	public function send($data) {

		$rules = [
			'to' => 'required|numericarray',
			'to.*.email' => 'required|email',
			'to.*.name' => 'required|string',
			'subject' => 'required|max:255|string',
			'body' => 'required'
		];

		$this->render($data, $rules);
	}

}