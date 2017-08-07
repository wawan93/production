<?php

namespace App\Http\Controllers;

use App\GdLogEntry;
use App\Invoice;
use App\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function save(Request $request)
    {
        $json = json_decode($request->get('data'), true);
        $list = $json['attachList'][0];

        $order = Order::find($request->get('order_id'));

        /** @var \Illuminate\Database\Query\Builder $invoice */
        $invoice = Invoice::create([
            'user_id' => (int)$request->get('user_id'),
            'order_id' => (int)$request->get('order_id'),
            'data' => json_encode($list),
            'download_hash_md5' => $list['download_hash_md5'],
        ]);

        GdLogEntry::create([
            'type' => 'invoice_polygraphy',
            'tg_bot_status' => 'inqueue',
            'user_id' => 2,
            'arg_id' => -1,
            'details' => serialize([
                'polygraphy_type' => $order->polygraphy_type,
                'invoice_id' => $invoice->first()->id,
                'order_id' => $request->get('order_id'),
                'user_id' => $request->get('user_id'),
            ]),
        ]);

        $allInvoicesUploaded = true;
        foreach ($order->team()->members() as $user) {
            $invoice = $order->invoices()->where('user_id', $user->id)->first();
            if ($invoice == null) {
                $allInvoicesUploaded = false;
                break;
            }
        }
        if ($allInvoicesUploaded) {
            $order->status = 'invoices';
            $order->save();
        }

        return response(json_encode(['error' => 'false']));
    }
}
