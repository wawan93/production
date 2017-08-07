<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Mail\OrderRequest;
use App\Order;
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
        $keyword = $request->get('search');
        $perPage = 25000;

        if (!empty($keyword)) {
            $order = Order::where('team_id', 'LIKE', "%$keyword%")
                ->orWhere('code_name', 'LIKE', "%$keyword%")
                ->orWhere('polygraphy_type', 'LIKE', "%$keyword%")
                ->orWhere('manager_id', 'LIKE', "%$keyword%")
                ->orWhere('alert', 'LIKE', "%$keyword%")
                ->orWhere('edition_initial', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->orWhere('polygraphy_format', 'LIKE', "%$keyword%")
                ->orWhere('edition_final', 'LIKE', "%$keyword%")
                ->orWhere('manufacturer', 'LIKE', "%$keyword%")
                ->orWhere('paid_date', 'LIKE', "%$keyword%")
                ->orWhere('final_date', 'LIKE', "%$keyword%")
                ->orWhere('ship_date', 'LIKE', "%$keyword%")
                ->orWhere('contact', 'LIKE', "%$keyword%")
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        } else {
            $order = Order::paginate($perPage);
        }

        return view('order.index', compact('order'));
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

        Mail::to($order->manufacturer())->send($template);
        $order->mail_sent = 1;
        $order->saveOrFail();

		return redirect('/order/' . $order->id . '/edit');
	}
}
