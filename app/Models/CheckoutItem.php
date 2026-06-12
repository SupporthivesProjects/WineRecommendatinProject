<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckoutItem extends Model
{
    protected $fillable = [
        'checkout_id',
        'product_id',
        'user_id',
        'store_manager_id',
        'product_name',
        'price',
        'quantity',
    ];


    public function checkout()
    {
        return $this->belongsTo(CartCheckout::class, 'checkout_id');
    }
}