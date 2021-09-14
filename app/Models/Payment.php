<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'user_id',
        'order_id',
        'type',
        'status',
    ];
    public const PAYMENT_CHANNELS = [
        "credit_card",
        "gopay",
        "shopeepay",
        "bca_va",
        "bni_va",
        "bri_va",
        "mandiri_clickpay",
        "bca_klikbca",
        "bca_klikpay",
        "bri_epay",
        "Indomaret",
        "alfamart"
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }
}
