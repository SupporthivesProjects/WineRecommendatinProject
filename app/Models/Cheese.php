<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheese extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'texture',
        'origin_country',
        'milk_type',
        'fat_content',
        'flavor_profile',
        'aging_period',
        'image',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'boolean',
        'fat_content' => 'decimal:2',
    ];

    /**
     * Get the wines that pair with this cheese.
     */
    public function wines()
    {
        return $this->belongsToMany(Product::class, 'wine_cheese_pairings', 'cheese_id', 'wine_id')
                    ->withPivot('pairing_strength', 'pairing_notes', 'is_recommended')
                    ->withTimestamps();
    }

    /**
     * Get wine cheese pairings for this cheese.
     */
    public function pairings()
    {
        return $this->hasMany(WineCheesePairing::class);
    }

    /**
     * Get the stores that sell this cheese.
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_cheese_products')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    /**
     * Get the store cheese products for this cheese.
     */
    public function storeCheeseProducts()
    {
        return $this->hasMany(StoreCheesProduct::class);
    }

    /**
     * Scope a query to only include active cheeses.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
