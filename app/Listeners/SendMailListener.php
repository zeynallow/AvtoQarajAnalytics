<?php

namespace App\Listeners;

use App\Events\SendMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Snowfire\Beautymail\Beautymail;

class SendMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  SendMail  $event
     * @return void
     */
    public function handle(SendMail $event)
    {
        $beautyMail = app()->make(Beautymail::class);
        $beautyMail->send($event->view, ['otpCode' => $event->otpCode], function($message) use ($event){
            $message->to($event->email)->subject($event->subject);
        });
    }
}
