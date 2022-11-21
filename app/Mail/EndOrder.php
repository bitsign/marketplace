<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EndOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $template;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $template = null)
    {
        $this->order = $order;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->template['subject'])->markdown('emails.orders.endorder')->with([
            'template' => $this->template
        ]);
    }
}
