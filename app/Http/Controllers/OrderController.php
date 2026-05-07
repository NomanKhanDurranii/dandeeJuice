<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function confirmation(Request $request, int $id): View
    {
        $order = Order::with('items')
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        return view('order-confirmation', compact('order'));
    }
}
