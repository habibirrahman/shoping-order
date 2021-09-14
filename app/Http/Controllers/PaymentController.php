<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use App\Models\Cart;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $payload = $request->getContent();
        $notification = json_decode($payload);

        // return response jika signature key invalid
        // $valid_signature_key = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));
        // if ($notification->signature_key != $valid_signature_key) {
        //     return response(['message' => 'invalid signature'], 403);
        // }

        // return response jika status order sudah 'paid'
        $order = Order::whereIn('key_id', [$notification->order_id])->get()->first();
        if ($order->payment_status == 'paid') {
            return response(['message' => 'the order has been paid before'], 422);
        }

        $this->initPaymentGateway();
        $payment_status = null;
        $transaction = $notification->transaction_status;
        $type = $notification->payment_type;
        $order_id = $notification->order_id;
        $fraud = $notification->fraud_status;

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    $payment_status = 'challenge';
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    $payment_status = 'success';
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $payment_status = 'settlement';
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $payment_status = 'pending';
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $payment_status = 'denied';
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'Expire'
            $payment_status = 'expire';
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $payment_status = 'denied';
        }

        $temp = explode('/', $order_id);
        $user_id = $temp[1];
        $order = $temp[2];

        $payment_params = [
            'user_id' => $user_id,
            'order_id' => $order,
            'type' => $type,
            'status' => $payment_status
        ];

        $payment = Payment::create($payment_params);

        // update data di table order dan table cart
        if ($payment_status == 'success' || $payment_status == 'settlement') {
            Order::where('id', $order)->update([
                'status' => 'produksi',
                'payment_status' => 'paid',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        return response(['message' => 'payment status is ' . $payment_status], 200);
    }

    public function completed(Request $request)
    {
        // dd(['completed', $request->query()]);
        return redirect()
            ->route('orders.index')
            ->with('success', 'checkout telah berhasil');
    }

    public function unfinish(Request $request)
    {
        // dd(['unfinish', $request->query()]);
        return redirect()
            ->route('carts.index')
            ->with('failed', 'checkout dibatalkan');
    }

    public function failed(Request $request)
    {
        // dd(['failed', $request->query()]);
        return redirect()
            ->route('carts.index')
            ->with('failed', 'checkout gagal, cobalah beberapa saat lagi');
    }
}
