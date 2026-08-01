<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubadminFeaturePermission extends Model
{
    protected $fillable = [
        'sub_admin_id',
        'feature_id',
    ];
}