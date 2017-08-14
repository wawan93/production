<?php

namespace App\Observers;


use App\GdLogEntry;
use App\Order;
use Illuminate\Support\Facades\Auth;

class OrderUpdateObserver
{
    public function updating(Order $order)
    {
        $changed = array_diff_assoc($order->getAttributes(), $order->getOriginal());
        $changedFields = array_keys($changed);

        if (in_array('manufacturer', $changedFields)) {
            $order->mail_sent = false;
        }

        if (in_array('recieved', $changedFields) && $order->recieved == true) {
            $order->status = 'shipped';
            $order->receive_time = date('Y-m-d H:i:s');
        }

        if (in_array('maket_ok', $changedFields)) {
            GdLogEntry::create([
                'type' => 'maket_f_approve',
                'tg_bot_status' => 'inqueue',
                'user_id' => Auth::id(),
                'arg_id' => Auth::id(),
                'details' => serialize(['order_id' => $order->id])
            ]);
        }

        if (in_array('status', $changedFields) && $order->status == 'production') {
            $order->in_progress = 0;
        }


    }
}