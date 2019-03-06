<?php

namespace App\Listeners;

use App\Events\MailSentEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\LogDeliveryService;
use Log;

class MailSentListener
{
    protected $log_delivery_service;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(LogDeliveryService $log_delivery_service)
    {
        $this->log_delivery_service = $log_delivery_service;
    }

    /**
     * Handle the event.
     *
     * @param  MailSentEvent  $event
     * @return void
     */
    public function handle(MailSentEvent $event)
    {   
        $this->log_delivery_service->make($event->data);
    }
}
