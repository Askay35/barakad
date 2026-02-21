<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $categoryId = $request->input('category_id');

        $query = Product::with('category');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        /** @var \Illuminate\Pagination\LengthAwarePaginator $products */
        $products = $query->latest('id')->paginate(20);
        $products->withQueryString();

        return view('admin.products', compact('products', 'categories', 'categoryId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'products/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $imageName);
            $validated['image'] = Storage::url('images/' . $imageName);
        }

        Product::create($validated);

        return back()->with('success', 'Блюдо создано.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($product->image) {
                $oldImagePath = str_replace('/storage/', '', parse_url($product->image, PHP_URL_PATH));
                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = 'products/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $imageName);
            $validated['image'] = Storage::url('images/' . $imageName);
        }

        $product->update($validated);

        return back()->with('success', 'Блюдо обновлено.');
    }

    public function destroy(Product $product)
    {
        // Удаляем изображение при удалении блюда
        if ($product->image) {
            $oldImagePath = str_replace('/storage/', '', parse_url($product->image, PHP_URL_PATH));
            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        $product->delete();
        return back()->with('success', 'Блюдо удалено.');
    }
}

