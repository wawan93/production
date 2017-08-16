<?php

namespace App\Observers;


use App\GdLogEntry;
use App\Order;
use Illuminate\Support\Facades\Auth;

class OrderUpdateObserver
{
    protected $order = null;

    public function updating(Order $order)
    {
        $this->order = $order;
        $changed = array_diff_assoc($order->getAttributes(), $order->getOriginal());
        $changedFields = array_keys($changed);

        if (in_array('manufacturer', $changedFields)) {
            $this->setMailSent($order, $changedFields);
        }

        if (in_array('recieved', $changedFields)) {
            $this->setShippedStatus($order, $changedFields);
        }

        if (in_array('maket_ok', $changedFields)) {
            $this->logMaketApprove($order, $changedFields);
        }

        if (in_array('status', $changedFields)) {
            GdLogEntry::create([
                'type' => 'ajax_update_order',
                'tg_bot_status' => 'none',
                'user_id' => Auth::id(),
                'arg_id' => $order->id,
                'details' => serialize([
                    'order_id' => $order->id,
                    'from' => $order->getOriginal('status'),
                    'to' => $order->status
                ])
            ]);
            $this->resetInProgressWhenProductionStarted($order, $changedFields);
        }

        if (in_array('edition_final', $changedFields)) {
            $this->notifyEditionChanged($order, $changedFields);
        }
    }

    /**
     * @param Order $order
     * @param $changedFields
     */
    private function setMailSent(Order $order, $changedFields)
    {
        $order->mail_sent = false;
    }

    /**
     * @param Order $order
     * @param $changedFields
     */
    private function setShippedStatus(Order $order, $changedFields)
    {
        if ($order->recieved == true) {
            $order->status = 'shipped';
            $order->receive_time = date('Y-m-d H:i:s');

            GdLogEntry::create([
                'type' => 'received_to_stock',
                'tg_bot_status' => 'inqueue',
                'user_id' => Auth::id(),
                'arg_id' => $order->id,
                'details' => serialize(['order_id' => $order->id])
            ]);
        }
    }

    /**
     * @param Order $order
     * @param $changedFields
     */
    private function logMaketApprove(Order $order, $changedFields)
    {
        GdLogEntry::create([
            'type' => 'maket_f_approve',
            'tg_bot_status' => 'inqueue',
            'user_id' => Auth::id(),
            'arg_id' => $order->id,
            'details' => serialize(['order_id' => $order->id])
        ]);
    }

    /**
     * @param Order $order
     * @param $changedFields
     */
    private function resetInProgressWhenProductionStarted(Order $order, $changedFields)
    {
        if ($order->status == 'production') {
            $order->in_progress = 0;
        }
    }

    /**
     * @param Order $order
     * @param $changedFields
     */
    private function notifyEditionChanged(Order $order, $changedFields)
    {
        $diff = abs($order->edition_final - $order->getOriginal('edition_final'));
        if ($diff >= 300) {
            GdLogEntry::create([
                'type' => 'change_edition_final',
                'tg_bot_status' => 'inqueue',
                'user_id' => Auth::id(),
                'arg_id' => $order->id,
                'details' => serialize([
                    'order_id' => $order->id,
                    'from' => $order->getOriginal('edition_final'),
                    'to' => $order->edition_final
                ])
            ]);
        }
    }
}