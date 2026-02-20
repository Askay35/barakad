@extends('admin.layout')
@section('title', 'Категории')

@section('content')
<div x-data="{ showCreate: false, editingId: null }">

<!-- Add Category Button -->
<div class="mb-6 flex justify-end">
    <button @click="showCreate = !showCreate"
            class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-xl transition-colors flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Добавить категорию
    </button>
</div>

<!-- Create Form -->
<div x-show="showCreate" x-cloak x-collapse class="mb-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h3 class="font-bold text-slate-900 mb-4">Новая категория</h3>
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Название</label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">URL изображения</label>
                    <input type="text" name="image" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm" placeholder="https://...">
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

<!-- Categories Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($categories as $category)
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden group">
        <!-- View Mode -->
        <div x-show="editingId !== {{ $category->id }}">
            <div class="relative aspect-video overflow-hidden">
                @if($category->image)
                <img src="{{ $category->image }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                <div class="w-full h-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                @endif
                <div class="absolute top-3 right-3">
                    <span class="bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-xs font-semibold text-slate-700">
                        {{ $category->products_count }} блюд
                    </span>
                </div>
            </div>
            <div class="p-5 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 text-lg">{{ $category->name }}</h3>
                <div class="flex items-center gap-1">
                    <button @click="editingId = {{ $category->id }}" class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Удалить категорию «{{ $category->name }}»?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Mode -->
        <div x-show="editingId === {{ $category->id }}" x-cloak class="p-5">
            <h3 class="font-bold text-slate-900 mb-3">Редактировать</h3>
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf @method('PUT')
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Название</label>
                        <input type="text" name="name" value="{{ $category->name }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-amber-500 outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">URL изображения</label>
                        <input type="text" name="image" value="{{ $category->image }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-amber-500 outline-none">
                    </div>
                </div>
                <div class="flex gap-2 mt-4">
                    <button type="submit" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg transition-colors">Сохранить</button>
                    <button type="button" @click="editingId = null" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-medium rounded-lg transition-colors">Отмена</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach
</div>

@if($categories->isEmpty())
<div class="text-center py-16 bg-white rounded-2xl border border-slate-200">
    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-10 h-10 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
        </svg>
    </div>
    <p class="text-slate-500 font-medium">Категорий пока нет</p>
</div>
@endif

</div>
@endsection

