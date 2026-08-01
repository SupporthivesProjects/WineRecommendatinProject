<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubadminFeature extends Model
{
    protected $table = 'subadmin_features';

    protected $fillable = [
        'feature_key',
        'feature_name',
        'is_enabled',
    ];
}