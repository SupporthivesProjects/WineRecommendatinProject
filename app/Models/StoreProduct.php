<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'product_id',
        'status',
        'is_featured',
    ];

    /**
     * Get the store that owns the store product.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the product that belongs to the store product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
