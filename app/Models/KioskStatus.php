<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KioskStatus extends Model
{
    protected $table = 'kiosk_statuses';

    protected $fillable = [
        'kiosk_id',
        'store_id',
        'user_id',
        'ip_address',
        'last_seen_at',
        'logged_in_at',
        'logged_out_at',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
        'logged_in_at' => 'datetime',
        'logged_out_at' => 'datetime',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
