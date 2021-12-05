<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // menampilkan data pesanan milik pelanggan tertentu
    public function index(Auth $auth)
    {
        $user = $auth::user();
        $data = [
            'user' => $user,
            'orders' => Order::whereIn('user_id', [$user->id])
                ->whereIn('payment_status', ['paid'])
                ->orderBy('for_date', 'DESC')
                ->get()
        ];
        return view('orders.index', compact('data'));
    }
    // melakukan pemeriksaan pesanan
    public function checkout(Auth $auth, Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = $auth::user();
        $orders = Order::whereIn('user_id', [$user->id])->get();
        foreach ($orders as $order) {
            if ($order->status == 'pending') {
                $order->delete();
            }
        }
        $temp = array_slice($request->input(), 1);
        if ($temp == null) {
            return redirect()
                ->route('carts.index')
                ->with('failed', 'Silakan checkout minimal 1 pesanan');
        }
        $carts = Cart::whereIn('id', $temp)->get();
        $items = [];
        $bill = 0;
        $total_item = 0;
        foreach ($carts as $cart) {
            array_push($items, $cart->id);
            $bill += $cart->price;
            $total_item += $cart->amount;
        }
        $carts_id = implode("-", $items);
        $data = [
            'user' => $user,
            'carts' => $carts,
            'carts_id' => $carts_id,
            'bill' => $bill,
            'total_item' => $total_item
        ];
        return view('orders.checkout', compact('data'));
    }

    public function pay(Auth $auth, Request $request, $all_cart)
    {
        date_default_timezone_set('Asia/Jakarta');
        $user = $auth::user();
        $carts_id = explode("-", $all_cart);
        $carts = Cart::whereIn('id', $carts_id)->get();
        $bill = 0;
        $number = 0;
        $item_details = [];
        foreach ($carts as $cart) {
            $bill += $cart->price;
            $number += $cart->price + $cart->amount;
            $item = [
                'id' => $cart->id,
                'price' => $cart->product->price,
                'quantity' => $cart->amount,
                'name' => $cart->product->name,
                'category' => $cart->product->category->name,
            ];
            array_push($item_details, $item);
        }
        $for_date = date("Y-m-d", strtotime($request->input('date')));

        // insert ke tabel orders dan update ke tabel cart
        $order_id = Order::insertGetId([
            'user_id' => $user->id,
            'for_date' => $for_date,
            'price' => $bill,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        foreach ($carts_id as $id) {
            Cart::where('id', $id)->update([
                'order_id' => $order_id,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        $key_id = 'DA' . '/' . $user->id . '/' . $order_id  . '/' . $number . '/STAG';

        // set payment midtrans snap-redirect
        $this->initPaymentGateway();
        $customer_details = [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'billing_address' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
            ],
            'shipping_address' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $user->address,
            ],
        ];
        $params = [
            'transaction_details' => [
                'order_id' => $key_id,
                'gross_amount' => $bill
            ],
            'item_details' => $item_details,
            'customer_details' => $customer_details,
            'enable_payment' => Payment::PAYMENT_CHANNELS,
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s T'),
                'unit' => 'days',
                'duration' => '7'
            ]
        ];
        // dd(($params));

        // Get Snap Payment Page URL
        $snap = \Midtrans\Snap::createTransaction($params);
        if ($snap->token) {
            $payment_token = $snap->token;
            $redirect_url = $snap->redirect_url;
        }

        // update tabel order
        Order::where('id', $order_id)->update([
            'key_id' => $key_id,
            'payment_token' => $payment_token,
            'redirect_url' => $redirect_url,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // // update tabel carts
        // foreach ($carts as $cart) {
        //     Cart::where('id', $cart->id)->update([
        //         'order_id' => $order_id,
        //         'status' => 'checked',
        //         'updated_at' => date('Y-m-d H:i:s')
        //     ]);
        // }

        // berpindah ke midtrans redirect url
        return redirect($redirect_url);
    }
}
