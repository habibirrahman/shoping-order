<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // menampilkan data keranjang milik pelanggan tertentu
    public function index(Auth $auth)
    {
        $user = $auth::user();
        // menghapus item jika amount=0
        $carts = Cart::whereIn('user_id', [$user->id])->get();
        foreach ($carts as $cart) {
            if ($cart->amount == 0) {
                $cart->delete();
            }
        }
        $orders = Order::whereIn('user_id', [$user->id])
            ->whereIn('payment_status', ['paid'])
            ->get();
        foreach ($orders as $order) {
            Cart::where('order_id', $order->id)->update([
                'status' => 'checked',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        $data = [
            'user' => $user,
            'carts' => Cart::whereIn('user_id', [$user->id])
                ->whereIn('status', ['oncart'])
                ->orderBy('created_at', 'DESC')
                ->get()
        ];
        return view('carts.index', compact('data'));
    }

    // menampilkan halaman tambah keranjang
    public function add(Auth $auth, $slug)
    {
        $user = $auth::user();
        $data = [
            'user' => $user,
            'product' => Product::whereIn('slug', [$slug])->get()->first()
        ];
        return view('carts.add', compact('data'));
    }
    // menambahkan keranjang
    public function store(Auth $auth, Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user_id = $auth::user()->id;
        $slug = $request->query('slug');
        $product = Product::whereIn('slug', [$slug])->get()->first();

        $request->merge([
            'user_id' => $user_id,
            'product_id' => $product->id,
            'price' => $request->input('amount') * $product->price,
            'status' => 'oncart'
        ]);
        Cart::create($request->all());
        return redirect()
            ->route('carts.index')
            ->with('success', $product->name . ' berhasil ditambahkan');
    }

    // menampilkan halaman edit keranjang
    public function edit(Auth $auth, Cart $cart)
    {
        $user = $auth::user();
        $data = [
            'user' => $user,
            'cart' => $cart
        ];
        return view('carts.edit', compact('data'));
    }
    // mengubah data keranjang
    public function update(Request $request, Cart $cart)
    {
        date_default_timezone_set('Asia/Jakarta');
        $request->merge([
            'price' => $request->input('amount') * $cart->product->price,
        ]);
        $cart->update($request->all());
        return redirect()->route('carts.index')
            ->with('success', 'data keranjang berhasil diupdate');
    }
}
