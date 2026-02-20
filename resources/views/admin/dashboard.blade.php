@extends('admin.layout')
@section('title', 'Статистика')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 border border-slate-200">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">Всего заказов</p>
                <p class="text-2xl font-bold text-slate-900">{{ $totalOrders }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-200">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">Завершённых</p>
                <p class="text-2xl font-bold text-slate-900">{{ $completedOrders }}</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-200">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">Общий доход</p>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($totalRevenue, 0, ',', ' ') }} ₽</p>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-2xl p-6 border border-slate-200">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-500">Средний чек</p>
                <p class="text-2xl font-bold text-slate-900">{{ number_format($averageOrder, 0, ',', ' ') }} ₽</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Revenue by Month -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200">
        <h3 class="font-bold text-slate-900 mb-4">Доход по месяцам</h3>
        @if($ordersByMonth->count() > 0)
        <div class="space-y-3">
            @php $maxRevenue = $ordersByMonth->max('revenue') ?: 1; @endphp
            @foreach($ordersByMonth as $month)
            <div class="flex items-center gap-4">
                <span class="text-sm text-slate-500 w-20 shrink-0">{{ $month->period }}</span>
                <div class="flex-1 bg-slate-100 rounded-full h-8 overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-400 to-orange-500 h-full rounded-full flex items-center px-3 transition-all"
                         style="width: {{ max(($month->revenue / $maxRevenue) * 100, 8) }}%">
                        <span class="text-xs font-semibold text-white whitespace-nowrap">{{ number_format($month->revenue, 0, ',', ' ') }} ₽</span>
                    </div>
                </div>
                <span class="text-sm text-slate-400 w-16 text-right shrink-0">{{ $month->count }} зак.</span>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-slate-400 text-sm py-8 text-center">Нет данных</p>
        @endif
    </div>

    <!-- Orders by Day of Week -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200">
        <h3 class="font-bold text-slate-900 mb-4">По дням недели</h3>
        @if($ordersByDayOfWeek->count() > 0)
        <div class="space-y-3">
            @php $maxDayCount = $ordersByDayOfWeek->max('count') ?: 1; @endphp
            @foreach($ordersByDayOfWeek as $day => $data)
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-slate-600 w-8 shrink-0">{{ $day }}</span>
                <div class="flex-1 bg-slate-100 rounded-full h-8 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-400 to-indigo-500 h-full rounded-full flex items-center px-3 transition-all"
                         style="width: {{ max(($data['count'] / $maxDayCount) * 100, 8) }}%">
                        <span class="text-xs font-semibold text-white whitespace-nowrap">{{ $data['count'] }} зак.</span>
                    </div>
                </div>
                <span class="text-sm text-slate-400 w-24 text-right shrink-0">{{ number_format($data['revenue'], 0, ',', ' ') }} ₽</span>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-slate-400 text-sm py-8 text-center">Нет данных</p>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Revenue by Year -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200">
        <h3 class="font-bold text-slate-900 mb-4">По годам</h3>
        @if($ordersByYear->count() > 0)
        <div class="space-y-3">
            @foreach($ordersByYear as $year)
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl">
                <div>
                    <p class="font-bold text-slate-900 text-lg">{{ $year->year }}</p>
                    <p class="text-sm text-slate-500">{{ $year->count }} заказов</p>
                </div>
                <p class="text-xl font-bold text-amber-600">{{ number_format($year->revenue, 0, ',', ' ') }} ₽</p>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-slate-400 text-sm py-8 text-center">Нет данных</p>
        @endif
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-900">Последние заказы</h3>
            <a href="{{ route('admin.orders') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">Все заказы →</a>
        </div>
        @if($recentOrders->count() > 0)
        <div class="space-y-3">
            @foreach($recentOrders as $order)
            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 transition-colors">
                <div class="flex items-center gap-3">
                    <span class="text-sm font-bold text-slate-900">#{{ $order->id }}</span>
                    @if($order->status->name === 'Текущий')
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">{{ $order->status->name }}</span>
                    @elseif($order->status->name === 'Завершён')
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">{{ $order->status->name }}</span>
                    @else
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">{{ $order->status->name }}</span>
                    @endif
                </div>
                <div class="text-right">
                    <p class="font-semibold text-slate-900">{{ number_format($order->cost, 0, ',', ' ') }} ₽</p>
                    <p class="text-xs text-slate-400">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-slate-400 text-sm py-8 text-center">Нет заказов</p>
        @endif
    </div>
</div>
@endsection

