<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // menampilkan kategori
    public function index(Auth $auth)
    {
        if ($auth::user()->role == 0) {
            return redirect()->route('home');
        }
        $data = [
            'categories' => Category::orderBy('name', 'ASC')->get(),
            'user' => $auth::user()
        ];
        return view('admin.categories.index', compact('data'));
    }
    // menambahkan data kategori baru
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $name = $request->input('name');
        $categories = Category::all();
        foreach ($categories as $category) {
            if ($category->name == $name) {
                return redirect()
                    ->route('categories.index')
                    ->with('failed', $name . ' category already exists');
            }
        }
        $request->merge([
            'slug' => Str::slug($name, '-')
        ]);
        Category::create($request->all());
        return redirect()
            ->route('categories.index')
            ->with('success', $name . ' category created successfully.');
    }
    // menampilkan halaman edit kategori
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    // mengubah data kategori
    public function update(Request $request, Category $category)
    {
        date_default_timezone_set('Asia/Jakarta');
        $name = $request->input('name');
        $categories = Category::all();
        foreach ($categories as $c) {
            if ($c->name == $name) {
                return redirect()
                    ->route('categories.index')
                    ->with('failed', $name . ' category already exists');
            }
        }
        $request->merge([
            'slug' => Str::slug($name, '-')
        ]);
        $category->update($request->all());
        return redirect()
            ->route('categories.index')
            ->with('success', $name . ' category updated successfully');
    }
    // menghapus data kategori
    public function destroy(Category $category)
    {
        date_default_timezone_set('Asia/Jakarta');
        $name = $category->name;
        $products = Product::all();
        $temp = [
            'category' => $name,
            'products' => []
        ];
        $i = 0;
        foreach ($products as $product) {
            if ($product->category_id == $category->id) {
                $temp['products'][$i++] = $product->name;
            }
        }

        if ($temp['products']) {
            return redirect()
                ->route('categories.index')
                ->with('category-delete-failed', $temp);
        } else {
            $category->delete();
            return redirect()
                ->route('categories.index')
                ->with('success', $name . ' category deleted successfully');
        }
    }

}
