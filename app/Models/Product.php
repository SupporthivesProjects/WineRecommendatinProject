<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wine_name',
        'type',
        'sp_mentions',
        'grape_variety',
        'varietal_blend',
        'vintage_year',
        'wine_sub_region',
        'winery',
        'designation',
        'alcohol_vol',
        'residual_sugar',
        'nature',
        'acidity',
        'tannin_level',
        'body',
        'aging',
        'barrel_type',
        'time_spent_aging',
        'closure_type',
        'aroma',
        'palate',
        'finish',
        'sweetness_level',
        'glass_ware',
        'retail_price',
        'discounts',
        'optimal_drinking',
        'style',
        'decanting_time',
        'ageing_potential',
        'cheese_pairing',
        'importer_info',
        'image1',
        'image2',
        'image3',
        'image4',
        'wine_story',
        'country',
        'tasting_notes',
        'status',
    ];

    /**
     * Get the stores associated with the product.
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_products')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
