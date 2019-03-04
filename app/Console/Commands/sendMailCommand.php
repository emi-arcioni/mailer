<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use App\Http\Controllers\SendMailController;

 
class sendMailCommand extends Command
{
    protected $send_mail;

    protected $signature = 'mail:send {params : Mail data}';
    protected $description = 'Sends an email according to given parameters';
 
    
    public function __construct(SendMailController $send_mail){
        parent::__construct();

        $this->send_mail = $send_mail;
    }
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $params = $this->argument('params');

        $response = $this->send_mail->sendWithDefaults();

        $this->info($response);
    }
}