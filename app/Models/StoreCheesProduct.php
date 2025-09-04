<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreCheesProduct extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'store_cheese_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'cheese_id',
        'status',
    ];

    /**
     * Get the store that owns the cheese product.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the cheese that belongs to the store.
     */
    public function cheese()
    {
        return $this->belongsTo(Cheese::class);
    }

    /**
     * Scope a query to only include active store cheese products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive store cheese products.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
}
