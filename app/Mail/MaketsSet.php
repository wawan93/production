<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MaketsSet extends Mailable
{
    use Queueable, SerializesModels;

    protected $orders;
    protected $intro;
    protected $signature;

    public function __construct($set_id, $intro = '', $signature = '')
    {
        $this->orders = Order::where('set_id', $set_id)->get();
        $this->intro = $intro;
        $this->signature = $signature;
        $this->subject('Отправка комплекта в печать');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.makets_set', [
            'orders' => $this->orders,
            'intro' => $this->intro,
            'signature' => $this->signature
        ]);
    }
}
