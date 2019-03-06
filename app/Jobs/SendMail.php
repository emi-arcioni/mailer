<?php

namespace App\Jobs;

use App\Http\Controllers\SendMailController;

class SendMail extends Job
{
    public $tries = 3;

    protected $send_mail;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(SendMailController $send_mail, $data)
    {
        $this->send_mail = $send_mail;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->send_mail->doSend($this->data);
    }
}
