<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'template_products'
        )->withTimestamps();
    }

    public function cheeseProducts()
    {
        return $this->belongsToMany(
            CheeseProduct::class,
            'template_cheese_products'
        )->withTimestamps();
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }


    
}
