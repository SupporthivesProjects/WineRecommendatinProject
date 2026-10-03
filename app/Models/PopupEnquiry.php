<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopupEnquiry extends Model
{
    protected $fillable = [
        'product_name',
        'name',
        'gender',
        'mobile',
        'description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}