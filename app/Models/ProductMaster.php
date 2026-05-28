<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_name',
        'product_category',
        'size',
        'pack_size',
        'type',
        'product_created_time',
        'product_modified_time',
    ];
}
