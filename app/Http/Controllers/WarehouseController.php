<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $order = Order::where('id', '>', 0);

        return view('warehouse.index', ['order'=> $order->paginate(1000), 'filter' => [], 'count' => $order->count()]);
    }
}
