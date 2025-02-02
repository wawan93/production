<?php

namespace App\Observers;


use App\GdLogEntry;
use App\Order;
use App\PolygraphyType;
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

        if (in_array('received', $changedFields)) {
            $this->setShippedStatus($order, $changedFields);
        }

        if (in_array('maket_ok', $changedFields)) {
            $this->logMaketApprove($order, $changedFields);
        }

        if (in_array('status', $changedFields)) {
            $this->logStatusChange($order);
            $this->resetInProgressWhenProductionStarted($order, $changedFields);
        }

        if (in_array('status', $changedFields) || in_array('ship_date', $changedFields)) {
            $order->status_changed_at = date('Y-m-d H:i:s');
            $this->notifyCandidates($order);
        }

        if (in_array('edition_final', $changedFields)) {
            $this->notifyEditionChanged($order, $changedFields);
        }

        if (in_array('s_diplo_warning', $changedFields)) {
            $this->logDiploWarning($order);
        }

        if (in_array('polygraphy_format', $changedFields)) {
            $this->changeFormat($order, $order->polygraphy_format);
        }

        if (!empty($order->getOriginal('final_date')) && $this->isPrintInfoChanged($order, $changedFields)) {
            GdLogEntry::create([
                'type' => 'pl_print_d_changed',
                'user_id' => Auth::id(),
                'arg_id' => $order->id,
                'tg_bot_status' => 'inqueue',
                'details' => serialize([
                    'order' => $order->id,
                    'team_id' => $order->team_id
                ])
            ]);
        }

    }

    private function isPrintInfoChanged(Order $order, $changedFields)
    {
        if (in_array('final_date', $changedFields) && !empty($order->getOriginal('final_date'))) {
            return true;
        }

        if (in_array('manufacturer', $changedFields) && !empty($order->getOriginal('manufacturer'))) {
            return true;
        }

        return false;
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
        if ($order->received == true) {
            $order->status = 'shipped';
            $order->status_changed_at = date('Y-m-d H:i:s');
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

    /**
     * @param Order $order
     */
    private function logStatusChange(Order $order)
    {
        GdLogEntry::create([
            'type' => 'ajax_update_order',
            'tg_bot_status' => 'none',
            'user_id' => Auth::id(),
            'arg_id' => $order->id,
            'details' => serialize([
                'order_id' => $order->id,
                'field' => 'status',
                'from' => $order->getOriginal('status'),
                'to' => $order->status
            ])
        ]);
    }

    /**
     * @param Order $order
     */
    private function logDiploWarning(Order $order)
    {
        GdLogEntry::create([
            'type' => 's_diplo_warning',
            'tg_bot_status' => 'inqueue',
            'user_id' => Auth::id(),
            'arg_id' => $order->id,
            'details' => serialize([
                'order_id' => $order->id,
                'status' => $order->s_diplo_warning
            ])
        ]);
    }

    /**
     * @param Order $order
     * @param string $format
     */
    private function changeFormat($order, $format)
    {
        $type = PolygraphyType::where('type', $order->type()->type)->where('format', $format)->first();
        $order->code_name = str_replace($order->type()->order_code, $type->order_code, $order->code_name);
        $order->invoice_subject = $type->mat_name;
    }

    private function notifyCandidates(Order $order)
    {
        if ($order->status == 'ordered' && in_array($order->getOriginal('status'), ['approved', 'fundraising_finished', 'invoices', 'paid'])) {
            GdLogEntry::create([
                'type' => 'set_was_ordered',
                'tg_bot_status' => 'inqueue',
                'user_id' => Auth::id(),
                'arg_id' => $order->id,
                'details' => serialize([
                    'order_id' => $order->id,
                    'team_id' => $order->team_id,
                    'set_id' => $order->set_id,
                    'status' => 'ordered',
                ])
            ]);
        }

        if (in_array($order->status, ['ordered', 'production', 'shipped'])) {
            if ($order->getOriginal('ship_date') !== $order->ship_date || $order->getOriginal('ship_time') !== $order->ship_time) {
                GdLogEntry::create([
                    'type' => 'ship_date_changed',
                    'tg_bot_status' => 'inqueue',
                    'user_id' => Auth::id(),
                    'arg_id' => $order->id,
                    'details' => serialize([
                        'order_id' => $order->id,
                        'team_id' => $order->team_id,
                        'set_id' => $order->set_id,
                        'from' => $order->getOriginal('ship_date'),
                        'to' => $order->ship_date,
                        'time' => $order->ship_time,
                    ])
                ]);
            }
        }
    }
}