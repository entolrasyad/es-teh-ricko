<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'cart' => 'required|json',
            'payment_method' => 'required',
        ]);
        // dd($data);

        $items = json_decode($data['cart'], true);
        $paymentMethod = $data['payment_method'];

        $grandTotal = array_reduce($items, fn($sum, $i) => $sum + $i['total'], 0);
        
        $order = DB::transaction(function() use ($items, $paymentMethod, $grandTotal) {
            $order = Order::create([
                'order_number'   => now()->format('YmdHisv') . Str::upper(Str::random(3)),
                'payment_method' => $paymentMethod,
                'total_amount'   => $grandTotal,
            ]);

            foreach ($items as $item) {
                // 1) Create the transaction record
                $order->transactions()->create([
                    'menu_id'     => $item['id'],
                    'size'        => $item['size'],
                    'quantity'    => $item['quantity'],
                    'total_price' => $item['total'],
                ]);

                // 2) Decrement the stock on the menu
                Menu::whereKey($item['id'])->decrement('stock', $item['quantity']);
            }
            
            return $order;
        });

        return redirect()
            ->route('orders.receipt', $order->id)
            ->with('success', 'TERIMA KASIH!');
    }
}
