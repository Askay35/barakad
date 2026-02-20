<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $statuses = OrderStatus::all();
        $statusId = $request->input('status_id');

        $query = Order::with(['status', 'paymentType', 'orderItems.product'])->latest();

        if ($statusId) {
            $query->where('status_id', $statusId);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders', compact('orders', 'statuses', 'statusId'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status_id' => 'required|exists:order_statuses,id',
        ]);

        $order->update(['status_id' => $validated['status_id']]);

        return back()->with('success', 'Статус заказа #' . $order->id . ' обновлён.');
    }

    public function destroy(Order $order)
    {
        $order->orderItems()->delete();
        $order->delete();

        return back()->with('success', 'Заказ #' . $order->id . ' удалён.');
    }
}

