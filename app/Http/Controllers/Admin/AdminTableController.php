<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class AdminTableController extends Controller
{
    public function index()
    {
        $tables = Table::orderBy('number')->paginate(50);
        return view('admin.tables', compact('tables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|integer|min:1|unique:tables,number',
            'is_enabled' => 'boolean',
        ]);

        Table::create([
            'number' => $validated['number'],
            'is_enabled' => $request->has('is_enabled') ? true : false,
        ]);

        return back()->with('success', 'Стол создан.');
    }

    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'number' => 'required|integer|min:1|unique:tables,number,' . $table->id,
            'is_enabled' => 'boolean',
        ]);

        $table->update([
            'number' => $validated['number'],
            'is_enabled' => $request->has('is_enabled') ? true : false,
        ]);

        return back()->with('success', 'Стол обновлён.');
    }

    public function toggleStatus(Table $table)
    {
        $table->update(['is_enabled' => !$table->is_enabled]);
        
        $status = $table->is_enabled ? 'включен' : 'отключен';
        return back()->with('success', "Стол #{$table->number} {$status}.");
    }

    public function destroy(Table $table)
    {
        // Проверяем, есть ли заказы на этот стол
        if ($table->orders()->count() > 0) {
            return back()->with('error', 'Нельзя удалить стол, на который есть заказы.');
        }

        $table->delete();
        return back()->with('success', 'Стол удалён.');
    }
}

