<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheesePairing extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The cheese products that belong to the pairing.
     */
    public function cheeseProducts()
    {
        return $this->belongsToMany(CheeseProduct::class, 'cheese_pairing_product', 'pairing_id', 'cheese_product_id');
    }
}
