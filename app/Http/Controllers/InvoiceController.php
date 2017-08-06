<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function save(Request $request)
    {
        $json = json_decode($request->get('data'), true);
        $list = $json['attachList'][0];
        $invoice = Invoice::create([
            'user_id' => (int)$request->get('user_id'),
            'order_id' => (int)$request->get('order_id'),
            'data' => json_encode($list),
            'download_hash_md5' => $list['download_hash_md5'],
        ]);
        return response(json_encode(['error' => 'false']));
    }
}
