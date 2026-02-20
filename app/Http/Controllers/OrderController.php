<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProducts;
use App\Models\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create()
    {
        $paymentTypes = PaymentType::all();
        return view('cart', compact('paymentTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'payment_type_id' => 'required|exists:payment_types,id',
            'comment' => 'nullable|string|max:1000',
            'table' => 'nullable|integer|min:1',
        ]);

        $totalCost = collect($validated['items'])->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = DB::transaction(function () use ($validated, $totalCost) {
            $order = Order::create([
                'cost' => $totalCost,
                'comment' => $validated['comment'] ?? null,
                'table' => $validated['table'] ?? null,
                'payment_type_id' => $validated['payment_type_id'],
                'status_id' => 1, // Текущий
            ]);

            foreach ($validated['items'] as $item) {
                OrderProducts::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }

            return $order;
        });

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'message' => 'Заказ успешно создан!',
        ]);
    }
}

