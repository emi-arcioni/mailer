<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\LogDeliveryService;

class LogTest extends TestCase
{
	use DatabaseTransactions;

	/**
	 * A basic test example.
	 *
	 * @return void
	 */

	public function testLog() {
		$data = [
			'to' => [
				[
					'email' => 'emilio@arcioni.com.ar',
					'name' => 'Emilio Arcioni'
				]
			],
			'subject' => 'This is a test subject',
			'body' => 'This is the e-mail body',
			'status_id' => 1
		];

		$log = new LogDeliveryService();
		$response = $log->make($data);
		$this->seeInDatabase('deliveries', ['email_to' => 'emilio@arcioni.com.ar']);
	}

}