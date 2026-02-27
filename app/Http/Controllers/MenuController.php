<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\Table;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __invoke(Request $request)
    {
        $categories = Category::all();
        $tables = Table::orderBy('number')->get();
        $selectedCategoryId = $request->integer('category_id') ?: null;
        $sort = $request->input('sort');
        
        $query = Product::with('category');
        
        if ($selectedCategoryId) {
            $query->where('category_id', $selectedCategoryId);
        }
        
        if (in_array($sort, ['asc', 'desc'])) {
            $query->orderBy('price', $sort);
        }

        $products = ProductResource::collection($query->paginate(50));

        return view('menu', [
            'categories' => $categories,
            'tables' => $tables,
            'products' => $products,
            'selectedCategoryId' => $selectedCategoryId,
            'currentSort' => $sort,
        ]);
    }
}
