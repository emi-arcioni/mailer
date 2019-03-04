<?php
 
namespace App\Console\Commands;
 
use Illuminate\Console\Command;
use App\Http\Controllers\SendMailController;
use App\Http\Requests\SendMailRequest;

 
class sendMailCommand extends Command
{
    protected $send_mail;
    protected $validate;

    protected $signature = 'mail:send {params : Mail data}';
    protected $description = 'Sends an email according to given parameters';
 
    
    public function __construct(
        SendMailController $send_mail,
        SendMailRequest $validate
    ){
        parent::__construct();

        $this->send_mail = $send_mail;
        $this->validate = $validate;
    }
 
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $params = json_decode($this->argument('params'), true);
        $this->validate->send($params ? $params : []);
        $response = $this->send_mail->doSend($params);

        $this->info($response);
    }
}