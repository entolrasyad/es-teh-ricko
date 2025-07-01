<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function show(Order $order)
    {
        // eager‐load the line items and their menus
        $order->load('transactions.menu');

        return view('orders.receipt', compact('order'));
    }
}
