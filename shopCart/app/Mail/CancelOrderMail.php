<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CancelOrderMail extends Mailable
{
    use Queueable, SerializesModels;

    private $orderId;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $id)
    {
        $this->orderId = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.cancelOrder',[
            'orderId'=>$this->orderId
        ]);
    }
}
