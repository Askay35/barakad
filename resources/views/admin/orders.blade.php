@extends('admin.layout')
@section('title', 'Заказы')

@section('content')
<!-- Status Filters -->
<div class="flex flex-wrap gap-2 mb-6">
    <a href="{{ route('admin.orders') }}"
       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ !$statusId ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
        Все
    </a>
    @foreach($statuses as $status)
    <a href="{{ route('admin.orders', ['status_id' => $status->id]) }}"
       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $statusId == $status->id ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
        @if($status->name === 'Текущий')
            <span class="inline-block w-2 h-2 rounded-full bg-blue-500 mr-1.5"></span>
        @elseif($status->name === 'Завершён')
            <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-1.5"></span>
        @else
            <span class="inline-block w-2 h-2 rounded-full bg-red-500 mr-1.5"></span>
        @endif
        {{ $status->name }}
    </a>
    @endforeach
</div>

<!-- Orders List -->
@if($orders->count() > 0)
<div class="space-y-4">
    @foreach($orders as $order)
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden" x-data="{ open: false }">
        <!-- Order Header -->
        <div class="p-5 flex flex-wrap items-center gap-4 cursor-pointer hover:bg-slate-50 transition-colors" @click="open = !open">
            <div class="flex items-center gap-3 min-w-[140px]">
                <span class="text-lg font-bold text-slate-900">#{{ $order->id }}</span>
                @if($order->status->name === 'Текущий')
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{ $order->status->name }}</span>
                @elseif($order->status->name === 'Завершён')
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">{{ $order->status->name }}</span>
                @else
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">{{ $order->status->name }}</span>
                @endif
            </div>
            
            <div class="flex items-center gap-6 flex-1 flex-wrap">
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $order->created_at->format('d.m.Y H:i') }}
                </div>
                @if($order->table)
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                    Стол {{ $order->table->number }}
                </div>
                @endif
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                    {{ $order->paymentType->name }}
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <span class="text-xl font-bold text-slate-900">{{ number_format($order->cost, 0, ',', ' ') }} ₽</span>
                <svg class="w-5 h-5 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>
        
        <!-- Order Details (collapsible) -->
        <div x-show="open" x-cloak x-collapse class="border-t border-slate-100">
            <!-- Products -->
            <div class="p-5 space-y-3">
                @foreach($order->orderItems as $item)
                <div class="flex items-center gap-4">
                    @if($item->product && $item->product->image)
                    <img src="{{ $item->product->image }}" alt="" class="w-12 h-12 rounded-lg object-cover">
                    @else
                    <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif
                    <div class="flex-1">
                        <p class="font-medium text-slate-900">{{ $item->product->name ?? 'Удалённое блюдо' }}</p>
                        <p class="text-sm text-slate-500">{{ $item->quantity }} × {{ number_format($item->product->price ?? 0, 0, ',', ' ') }} ₽</p>
                    </div>
                    <p class="font-semibold text-slate-900">{{ number_format(($item->product->price ?? 0) * $item->quantity, 0, ',', ' ') }} ₽</p>
                </div>
                @endforeach

                @if($order->comment)
                <div class="mt-3 p-3 bg-amber-50 rounded-xl border border-amber-100">
                    <p class="text-sm text-amber-800"><span class="font-semibold">Комментарий:</span> {{ $order->comment }}</p>
                </div>
                @endif
            </div>
            
            <!-- Actions -->
            <div class="px-5 py-4 bg-slate-50 flex flex-wrap gap-2">
                @if($order->status->name === 'Текущий')
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status_id" value="2">
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Готово
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status_id" value="3">
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Отменить
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status_id" value="1">
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Вернуть в текущие
                        </button>
                    </form>
                @endif
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Удалить заказ #{{ $order->id }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 text-sm font-medium rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Удалить
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $orders->links() }}
</div>
@else
<div class="text-center py-16 bg-white rounded-2xl border border-slate-200">
    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-10 h-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
    </div>
    <p class="text-slate-500 font-medium">Заказов пока нет</p>
</div>
@endif
@endsection

