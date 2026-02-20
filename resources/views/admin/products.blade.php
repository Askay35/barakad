@extends('admin.layout')
@section('title', 'Блюда')

@section('content')
<div x-data="{ showCreate: false, editingId: null }">

<!-- Category Filter + Add Button -->
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.products') }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ !$categoryId ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Все
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('admin.products', ['category_id' => $cat->id]) }}"
           class="px-4 py-2 rounded-xl text-sm font-medium transition-colors {{ $categoryId == $cat->id ? 'bg-slate-900 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            {{ $cat->name }}
        </a>
        @endforeach
    </div>
    <button @click="showCreate = !showCreate"
            class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-xl transition-colors flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Добавить блюдо
    </button>
</div>

<!-- Create Form -->
<div x-show="showCreate" x-cloak x-collapse class="mb-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h3 class="font-bold text-slate-900 mb-4">Новое блюдо</h3>
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Название</label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Цена (₽)</label>
                    <input type="number" name="price" step="0.01" min="0" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Категория</label>
                    <select name="category_id" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm">
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Описание</label>
                    <input type="text" name="description" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Изображение</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm">
                </div>
            </div>
            <div class="flex gap-2 mt-4">
                <button type="submit" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-xl transition-colors text-sm">
                    Создать
                </button>
                <button type="button" @click="showCreate = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors text-sm">
                    Отмена
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Блюдо</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Категория</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Цена</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($products as $product)
                <tr class="hover:bg-slate-50 transition-colors">
                    <!-- View Mode -->
                    <td class="px-5 py-4" x-show="editingId !== {{ $product->id }}">
                        <div class="flex items-center gap-3">
                            @if($product->image)
                            <img src="{{ $product->image }}" alt="" class="w-12 h-12 rounded-lg object-cover">
                            @else
                            <div class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            @endif
                            <div>
                                <p class="font-semibold text-slate-900">{{ $product->name }}</p>
                                <p class="text-sm text-slate-500 truncate max-w-xs">{{ $product->description }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4" x-show="editingId !== {{ $product->id }}">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">{{ $product->category->name }}</span>
                    </td>
                    <td class="px-5 py-4" x-show="editingId !== {{ $product->id }}">
                        <span class="font-semibold text-slate-900">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
                    </td>
                    <td class="px-5 py-4 text-right" x-show="editingId !== {{ $product->id }}">
                        <div class="flex items-center justify-end gap-2">
                            <button @click="editingId = {{ $product->id }}" class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Удалить блюдо?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>

                    <!-- Edit Mode -->
                    <td colspan="4" class="px-5 py-4" x-show="editingId === {{ $product->id }}" x-cloak>
                        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                <input type="text" name="name" value="{{ $product->name }}" required class="px-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-amber-500 outline-none">
                                <input type="number" name="price" value="{{ $product->price }}" step="0.01" min="0" required class="px-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-amber-500 outline-none">
                                <select name="category_id" required class="px-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-amber-500 outline-none">
                                    @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="description" value="{{ $product->description }}" required class="sm:col-span-2 px-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-amber-500 outline-none">
                                <div class="sm:col-span-2">
                                    <label class="block text-xs text-slate-600 mb-1">Изображение (оставьте пустым, чтобы не менять)</label>
                                    <input type="file" name="image" accept="image/*" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-amber-500 outline-none">
                                </div>
                            </div>
                            <div class="flex gap-2 mt-3">
                                <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">Сохранить</button>
                                <button type="button" @click="editingId = null" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">Отмена</button>
                            </div>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $products->links() }}
</div>

</div>
@endsection

