<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CheeseProduct extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image'
    ];

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'store_inventory')
            ->withPivot(['quantity', 'is_active'])
            ->withTimestamps();
    }
}
