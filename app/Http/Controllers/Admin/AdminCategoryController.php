<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'categories/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $imageName);
            $validated['image'] = Storage::url('images/' . $imageName);
        }

        Category::create($validated);

        return back()->with('success', 'Категория создана.');
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($category->image) {
                $oldImagePath = str_replace('/storage/', '', parse_url($category->image, PHP_URL_PATH));
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = 'categories/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $imageName);
            $validated['image'] = Storage::url('images/' . $imageName);
        }

        $category->update($validated);

        return back()->with('success', 'Категория обновлена.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Нельзя удалить категорию с блюдами.');
        }

        // Удаляем изображение при удалении категории
        if ($category->image) {
            $oldImagePath = str_replace('/storage/', '', parse_url($category->image, PHP_URL_PATH));
            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        $category->delete();
        return back()->with('success', 'Категория удалена.');
    }
}

