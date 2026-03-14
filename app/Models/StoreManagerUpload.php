<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreManagerUpload extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_manager_name',
        'store_manager_id',
        'invoice_no',
        'customer_name',
        'customer_mobile',
        'product_name',
        'product_price',
        'date'
    ];


}
