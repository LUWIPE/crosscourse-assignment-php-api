<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function carts()
    {
        return $this->belongsTo(Cart::class);
    }
}
