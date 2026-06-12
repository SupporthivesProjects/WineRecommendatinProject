<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CheckoutItem;

class CartCheckout extends Model
{
    use HasFactory;
    protected $table = 'cart_checkouts'; // optional if Laravel's naming conventions used

    protected $fillable = [
        'username',
        'email',
        'phone',
        'submission_id',
        'products',
    ];

    protected $casts = [
        'products' => 'array', // to auto cast JSON column to PHP array
    ];

    public function items()
    {
        return $this->hasMany(CheckoutItem::class, 'checkout_id');
    }



}
