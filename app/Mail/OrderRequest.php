<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderRequest extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $intro;
    protected $signature;

    public function __construct(Order $order, $intro = '', $signature = '')
    {
    	$this->order = $order;
    	$this->intro = $intro;
    	$this->signature = $signature;
    	$this->subject('Заказ ' . $order->code_name);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.order_request', [
            'order' => $this->order,
            'intro' => $this->intro,
            'signature' => $this->signature
        ]);
    }
}
