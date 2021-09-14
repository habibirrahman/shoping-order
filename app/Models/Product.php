<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'file_image',
        'price',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
    public function cart()
    {
        return $this->hasMany('App\Models\Cart');
    }
}
