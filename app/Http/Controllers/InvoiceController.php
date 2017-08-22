<?php

namespace App\Http\Controllers;

use App\GdLogEntry;
use App\Invoice;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        $logArray = [
            'type' => 'invoice_polygraphy',
            'tg_bot_status' => 'inqueue',
            'user_id' => Auth::id(),
            'arg_id' => Auth::id(),
            'details' => serialize([
                'polygraphy_type' => $order->polygraphy_type,
                'invoice_id' => $invoice->first()->id,
                'order_id' => $request->get('order_id'),
                'user_id' => $request->get('user_id'),
            ]),
        ];

        $count = Invoice::whereOrderId($request->get('order_id'))->count();
        if ($count == 0) {
            $logArray['details']['is_first_invoice'] = true;
        }

        GdLogEntry::create($logArray);

        $allInvoicesUploaded = true;
        foreach ($order->members() as $user) {
            $invoice = $order->invoices()->where('user_id', $user->id)->first();
            if ($invoice == null) {
                $allInvoicesUploaded = false;
                break;
            }
        }
        if ($allInvoicesUploaded && in_array($order->status, ['approved', 'fundraising_finished'])) {
            $order->status = 'invoices';
            $order->save();
        }

        return response(json_encode(['error' => 'false']));
    }

    public function delete($type, Request $request)
    {
        Invoice::destroy($request->get('id'));

        Session::flash('flash_message', 'Счёт удалён!');

        return response(json_encode(['error' => 'false']));
    }
}
