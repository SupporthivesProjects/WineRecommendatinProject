<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_name',
        'product_category',
        'product_subcategory',
        'qty_per_unit',
        'stock',
        'location',
        'mrp',
    ];
}
