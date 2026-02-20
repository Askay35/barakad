<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalOrders = Order::count();
        $completedOrders = Order::where('status_id', 2)->count();
        $totalRevenue = Order::where('status_id', 2)->sum('cost');
        $averageOrder = $completedOrders > 0 ? round($totalRevenue / $completedOrders) : 0;

        // Orders by month (last 12 months)
        $ordersByMonth = Order::where('status_id', 2)
            ->where('created_at', '>=', now()->subMonths(12))
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as period"),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(cost) as revenue')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        // Orders by day of week
        $ordersByDayOfWeek = Order::where('status_id', 2)
            ->select(
                DB::raw('DAYOFWEEK(created_at) as day_num'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(cost) as revenue')
            )
            ->groupBy('day_num')
            ->orderBy('day_num')
            ->get()
            ->mapWithKeys(function ($item) {
                $days = [1 => 'Вс', 2 => 'Пн', 3 => 'Вт', 4 => 'Ср', 5 => 'Чт', 6 => 'Пт', 7 => 'Сб'];
                return [$days[$item->day_num] => ['count' => $item->count, 'revenue' => $item->revenue]];
            });

        // Orders by year
        $ordersByYear = Order::where('status_id', 2)
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(cost) as revenue')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        // Recent orders
        $recentOrders = Order::with(['status', 'paymentType'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders', 'completedOrders', 'totalRevenue', 'averageOrder',
            'ordersByMonth', 'ordersByDayOfWeek', 'ordersByYear', 'recentOrders'
        ));
    }
}

