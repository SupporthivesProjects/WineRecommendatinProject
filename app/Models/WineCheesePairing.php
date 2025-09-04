<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WineCheesePairing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wine_id',
        'cheese_id',
        'pairing_strength',
        'pairing_notes',
        'is_recommended',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_recommended' => 'boolean',
    ];

    /**
     * Get the wine that belongs to the pairing.
     */
    public function wine()
    {
        return $this->belongsTo(Product::class, 'wine_id');
    }

    /**
     * Get the cheese that belongs to the pairing.
     */
    public function cheese()
    {
        return $this->belongsTo(Cheese::class);
    }

    /**
     * Scope a query to only include recommended pairings.
     */
    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true);
    }

    /**
     * Scope a query to filter by pairing strength.
     */
    public function scopeByStrength($query, $strength)
    {
        return $query->where('pairing_strength', $strength);
    }
}
