<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'terms_accepted',
        'ip_address',
    ];

    protected $casts = [
        'terms_accepted' => 'boolean',
    ];
}
