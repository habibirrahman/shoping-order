<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // menampilkan data produk
    public function index(Auth $auth)
    {
        $user = $auth::user();
        if ($user->role == 0) {
            return redirect()->route('home');
        }
        $data = [
            'products' => Product::orderBy('name', 'ASC')->get(),
            'categories' => Category::orderBy('created_at', 'ASC')->get(),
            'user' => $user
        ];
        return view('admin.products.index', compact('data'));
    }
    // menambahkan data produk baru
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $name = $request->get('name');
        $products = Product::all();
        foreach ($products as $product) {
            if ($product->name == $name) {
                return redirect()
                    ->route('products.index')
                    ->with('failed', $name . ' product already exists');
            }
        }
        $file_name = $this->uploadFileImage($request);
        $request->merge([
            'slug' => Str::slug($name, '-'),
            'file_image' => $file_name
        ]);
        if (Product::create($request->all())) {
            return redirect()
                ->route('products.index')
                ->with('success', $name . ' product added successfully');
        } else {
            return redirect()
                ->route('products.index')
                ->with('failed', $name . ' product failed to add');
        }
    }
    // menampilkan halaman edit produk
    public function edit(Product $product)
    {
        $data = [
            'product' => $product,
            'categories' => Category::orderBy('name', 'ASC')->get()
        ];
        return view('admin.products.edit', compact('data'));
    }
    // mengubah data produk
    public function update(Request $request, Product $product)
    {
        date_default_timezone_set('Asia/Jakarta');
        $name = $request->input('name');
        if ($request->file()) {
            Storage::disk('local')->delete('public/images/' . $product->file_image);
            $file_name = $this->uploadFileImage($request);
        } else {
            $file_name = $product->file_image;
        }
        $request->merge([
            'slug' => Str::slug($name, '-'),
            'file_image' => $file_name,
        ]);
        $product->update($request->all());
        return redirect()->route('products.index')
            ->with('success', $name . ' product updated successfully');
    }
    // menghapus data produk
    public function destroy(Product $product)
    {
        date_default_timezone_set('Asia/Jakarta');
        $product->delete();
        Storage::disk('public')->delete($product->file_image);
        return redirect()
            ->route('products.index')
            ->with('success', $product->name . ' product were successfully removed');
    }
    // mengupload file gambar
    public function uploadFileImage($request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $name = $request->input('name');
        $file = $request->file('file');
        $size = $file->getSize();
        $extension = $file->getClientOriginalExtension();
        $file_name = Str::slug($name, '-') . '.' . $extension;
        if ($extension == "png" || $extension == "jpg" || $extension == "jpeg") {
            if ($size <= 2048000) {
                Storage::disk('public')->put($file_name, file_get_contents($file));
            } else {
                return redirect()
                    ->route('products.index')
                    ->with('failed', 'Your image file size is too big, please choose a size under 2MB');
            }
        } else {
            return redirect()
                ->route('products.index')
                ->with('failed', 'Your image file extension is wrong, please select a png, jpg, or jpeg image file');
        }
        return $file_name;
    }
}
