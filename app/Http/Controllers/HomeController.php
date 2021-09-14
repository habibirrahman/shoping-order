<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // menampilkan data pada halaman beranda
    public function index(Auth $auth)
    {
        $user = $auth::user();
        $data = [
            'products' => Product::orderBy('created_at', 'DESC')->get(),
            'category' => Category::all(),
            'user' => $user
        ];
        if ($user) {
            if ($user->role == 2)
                return redirect()->route('products.index');
        }
        return view('home', compact('data'));
    }
}
