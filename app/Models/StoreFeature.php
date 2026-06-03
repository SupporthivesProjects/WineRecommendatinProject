<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreFeature extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'feature_id',
        'enabled',
    ];

}
