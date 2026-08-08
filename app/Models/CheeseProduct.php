<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheeseProduct extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cheese_products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'is_active'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The stores that belong to the cheese product.
     */
    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class, 'store_inventory')
            ->withPivot(['quantity', 'is_available'])
            ->withTimestamps();
    }

    public function templates()
    {
        return $this->belongsToMany(
            Template::class,
            'template_cheese_products'
        )->withTimestamps();
    }

}
