<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
        'key_id',
        'user_id',
        'for_date',
        'price',
        'status',
        'payment_status',
        'payment_token',
        'redirect_url',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    public function cart()
    {
        return $this->hasMany('App\Models\Cart');
    }
    public function payment()
    {
        return $this->hasMany('App\Models\Payment');
    }
}
