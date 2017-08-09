<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Mail\OrderRequest;
use App\Order;
use App\Team;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Mail;
use Session;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $order = Order::where('id', '>', 0);

        $filter = (array)$request->get('filter');

        if (@$filter['manager']) {
            $order->where('manager_id', $filter['manager']);
        }

        if (@$filter['code_name']) {
            $order->where('code_name', 'like', '%' . $filter['code_name'] . '%');
        }

        if (@$filter['status']) {
            $order->where('status', $filter['status']);
        }

        if (@$filter['manufacturer']) {
            $order->where('manufacturer', $filter['manufacturer']);
        }

        if (@$filter['paid_date']) {
            $order->where('paid_date', $filter['paid_date']);
        }

        if (@$filter['final_date']) {
            $order->where('final_date', $filter['final_date']);
        }

        if (@$filter['ship_date']) {
            $order->where('ship_date', $filter['ship_date']);
        }

        return view('order.index', ['order'=> $order->paginate(1000), 'filter' => $filter, 'count' => $order->count()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {

        $requestData = $request->all();

        Order::create($requestData);

        Session::flash('flash_message', 'Order added!');

        return redirect('order');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);

        return view('order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $requestData = $request->all();

        $order = Order::findOrFail($id);
        $order->update($requestData);

        Session::flash('flash_message', 'Order updated!');
        return redirect('/order/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Order::destroy($id);

        Session::flash('flash_message', 'Order deleted!');

        return redirect('order');
    }

    public function viewMail($id, Request $request)
    {
        $order = Order::findOrFail($id);
        $template = new OrderRequest($order);

        return view('order.request', ['order' => $order]);
    }

    public function sendMail($id, Request $request)
    {
        $order = Order::findOrFail($id);
        $template = new OrderRequest($order, $request->get('intro'), $request->get('signature'));
        dump($template);

        Mail::to($order->manufacturer())->bcc('prod@gudkov.ru')->send($template);
        $order->mail_sent = 1;
        $order->saveOrFail();

        return redirect('/order/' . $order->id . '/edit');
    }

    public function approveMaket(Request $request)
    {
        $output = ['error' => 'false'];
        try {
            $order = Order::where('code_name', $request->get('code_name'))->first();
            $order->maket_ok = true;
            $order->save();
        } catch (Exception $e) {
            $output = [
                'error' => 'true',
                'error_text' => 'не удалось сохранить макет'
            ];
        }
        return response()->json($output);
    }
}
