<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\MailjetService;
use App\Services\SendgridService;

class SendMailTest extends TestCase
{

	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	
	public function testSendMailjet(){
		$mailjet = new MailjetService();

		$data = [
			'to' => [
				[
					'email' => 'emilio@arcioni.com.ar',
					'name' => 'Emilio Arcioni'
				]
			],
			'subject' => 'This is a test subject',
			'body' => 'This is the e-mail body'
		];
		$response = $mailjet->make($data);
		$this->assertTrue(is_array($response));
		$this->seeInDatabase('deliveries', ['email_to' => 'emilio@arcioni.com.ar']);
	}

	public function testSendMailJetPartial() {
		$mailjet = new MailjetService();

		$data = [
			'to' => [
				[
					'email' => 'emilio@arcioni.com.ar',
					'name' => 'Emilio Arcioni'
				]
			]
		];
		$response = $mailjet->make($data);
		$this->assertTrue(is_array($response));
		$this->seeInDatabase('deliveries', ['email_to' => 'emilio@arcioni.com.ar']);
	}

	public function testSendgrid(){
		$sendgrid = new SendgridService();

		$data = [
			'to' => [
				[
					'email' => 'emilio@arcioni.com.ar',
					'name' => 'Emilio Arcioni'
				]
			],
			'subject' => 'This is a test subject',
			'body' => 'This is the e-mail body'
		];
		$response = $sendgrid->make($data);
		$this->assertTrue($response == 202);
		$this->seeInDatabase('deliveries', ['email_to' => 'emilio@arcioni.com.ar']);
	}

	public function testEmpty() {
		$mailjet = new MailjetService();
		$response = $mailjet->make([]);

		$this->assertTrue($response['Status'] == 'error');
	}
}
