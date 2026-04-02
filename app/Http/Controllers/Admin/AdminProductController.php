<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:32768',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeCompressedImage($request->file('image'), 'products');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:32768',
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

            $validated['image'] = $this->storeCompressedImage($request->file('image'), 'products');
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

    /**
     * Сжать и сохранить изображение блюда.
     */
    private function storeCompressedImage(UploadedFile $image, string $folder): string
    {
        // SVG не обрабатываем через GD – сохраняем как есть
        if (strtolower($image->getClientOriginalExtension()) === 'svg') {
            $imageName = $folder . '/' . time() . '_' . uniqid() . '.svg';
            $image->storeAs('public/images', $imageName);
            return Storage::url('images/' . $imageName);
        }

        $realPath = $image->getRealPath();
        if (!$realPath || !file_exists($realPath)) {
            // fallback: обычное сохранение
            $imageName = $folder . '/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            return Storage::url('images/' . $imageName);
        }

        [$width, $height, $type] = @getimagesize($realPath);
        if (!$width || !$height) {
            $imageName = $folder . '/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            return Storage::url('images/' . $imageName);
        }

        switch ($type) {
            case IMAGETYPE_JPEG:
                $src = imagecreatefromjpeg($realPath);
                $ext = 'jpg';
                break;
            case IMAGETYPE_PNG:
                $src = imagecreatefrompng($realPath);
                $ext = 'png';
                break;
            case IMAGETYPE_GIF:
                $src = imagecreatefromgif($realPath);
                $ext = 'gif';
                break;
            default:
                // неизвестный тип — сохраняем как есть
                $imageName = $folder . '/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images', $imageName);
                return Storage::url('images/' . $imageName);
        }

        if (!$src) {
            $imageName = $folder . '/' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            return Storage::url('images/' . $imageName);
        }

        $maxWidth = 1600;
        $maxHeight = 1600;
        $scale = min(1, $maxWidth / $width, $maxHeight / $height);

        $newWidth = (int) round($width * $scale);
        $newHeight = (int) round($height * $scale);

        if ($scale < 1) {
            $dst = imagecreatetruecolor($newWidth, $newHeight);

            // поддержка прозрачности для PNG/GIF
            if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_GIF], true)) {
                imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
            }

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        } else {
            $dst = $src;
        }

        ob_start();
        if ($type === IMAGETYPE_JPEG) {
            imagejpeg($dst, null, 80); // качество 80
        } elseif ($type === IMAGETYPE_PNG) {
            imagepng($dst, null, 7);
        } else {
            imagegif($dst);
        }
        $contents = ob_get_clean();

        if ($dst !== $src) {
            imagedestroy($dst);
        }
        imagedestroy($src);

        $imageName = $folder . '/' . time() . '_' . uniqid() . '.' . $ext;
        Storage::put('public/images/' . $imageName, $contents);

        return Storage::url('images/' . $imageName);
    }
}

