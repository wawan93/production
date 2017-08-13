<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $order = Order::warehouse();

        $filter = (array)$request->get('filter');

        if (@$filter['code_name']) {
            $order->where('code_name', 'like', '%' . $filter['code_name'] . '%');
        }

        if (@$filter['status']) {
            $order->where('status', $filter['status']);
        }

        if (@$filter['manufacturer']) {
            $order->where('manufacturer', $filter['manufacturer']);
        }

        if (@$filter['ship_date']) {
            $order->where('ship_date', $filter['ship_date']);
        }

        if (@$filter['received']) {
            $order->where('received', 1);
        }

        if (@$filter['sorted']) {
            $order->where('sorted', 1);
        }

        if (@$filter['delivery']) {
            $order->where('delivery', 1);
        }

        if (@$filter['docs']) {
            $order->where('docs', 1);
        }

        if (@$filter['docs_in_shtab']) {
            $order->where('docs_in_shtab', 1);
        }


        return view('warehouse.index', ['order'=> $order->paginate(1000), 'filter' => [], 'count' => $order->count()]);
    }
}
