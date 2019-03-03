<?php

namespace App\Interfaces;
use Illuminate\Http\Request;

interface MailSenderInterface {
	public function sendUsingMailjet($data);
	public function sendUsingSendgrid();
}