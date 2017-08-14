<?php

namespace App\Http\Controllers;

use App\Mail\MaketsSet;
use App\Mail\OrderRequest;
use App\Manufacturer;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function preview($type, $id, Request $request)
    {
        $orders = Order::where('set_id', $id)->get();

        return view('emails.preview.'.$type, ['orders' => $orders, 'id' => $id]);
    }

    public function send($type, $id, Request $request)
    {
        $template = new MaketsSet(
            $id,
            $request->get('intro'),
            $request->get('signature')
        );

        Mail::to(Manufacturer::find($request->get('manufacturer')))
            ->send($template);

        Session::flash('flash_message', 'Отправлено!');

//        dump($request);
        return redirect('/order');
    }

}
