@extends('admin.layout')
@section('title', 'Столы')

@section('content')
<div x-data="{ showCreate: false, editingId: null }">

<!-- Add Button -->
<div class="mb-6 flex justify-end">
    <button @click="showCreate = !showCreate"
            class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-xl transition-colors flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Добавить стол
    </button>
</div>

<!-- Create Form -->
<div x-show="showCreate" x-cloak x-collapse class="mb-6">
    <div class="bg-white rounded-2xl border border-slate-200 p-6">
        <h3 class="font-bold text-slate-900 mb-4">Новый стол</h3>
        <form method="POST" action="{{ route('admin.tables.store') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Номер стола</label>
                    <input type="number" name="number" min="1" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 outline-none text-sm">
                </div>
                <div class="flex items-end">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_enabled" value="1" checked class="w-4 h-4 text-amber-500 border-slate-300 rounded focus:ring-amber-500">
                        <span class="text-sm font-medium text-slate-700">Включен</span>
                    </label>
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

<!-- Tables Table -->
<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Номер</th>
                    <th class="text-left px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Статус</th>
                    <th class="text-right px-5 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Действия</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($tables as $table)
                <tr class="hover:bg-slate-50 transition-colors">
                    <!-- View Mode -->
                    <td class="px-5 py-4" x-show="editingId !== {{ $table->id }}">
                        <span class="font-semibold text-slate-900">Стол #{{ $table->number }}</span>
                    </td>
                    <td class="px-5 py-4" x-show="editingId !== {{ $table->id }}">
                        @if($table->is_enabled)
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Включен</span>
                        @else
                            <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Отключен</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-right" x-show="editingId !== {{ $table->id }}">
                        <div class="flex items-center justify-end gap-2">
                            <form method="POST" action="{{ route('admin.tables.toggle', $table) }}" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="p-2 rounded-lg {{ $table->is_enabled ? 'text-green-600 hover:bg-green-50' : 'text-red-600 hover:bg-red-50' }} transition-colors"
                                        title="{{ $table->is_enabled ? 'Отключить' : 'Включить' }}">
                                    @if($table->is_enabled)
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    @endif
                                </button>
                            </form>
                            <button @click="editingId = {{ $table->id }}" class="p-2 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <form method="POST" action="{{ route('admin.tables.destroy', $table) }}" onsubmit="return confirm('Удалить стол?')" class="inline">
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
                    <td colspan="3" class="px-5 py-4" x-show="editingId === {{ $table->id }}" x-cloak>
                        <form method="POST" action="{{ route('admin.tables.update', $table) }}">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs text-slate-600 mb-1">Номер стола</label>
                                    <input type="number" name="number" value="{{ $table->number }}" min="1" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm focus:border-amber-500 outline-none">
                                </div>
                                <div class="flex items-end">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" name="is_enabled" value="1" {{ $table->is_enabled ? 'checked' : '' }} class="w-4 h-4 text-amber-500 border-slate-300 rounded focus:ring-amber-500">
                                        <span class="text-sm text-slate-700">Включен</span>
                                    </label>
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
    {{ $tables->links() }}
</div>

</div>
@endsection

