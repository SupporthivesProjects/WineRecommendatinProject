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
        'method',
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
        'admin_featured_product',
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

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('display_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Get all reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get only approved reviews for the product.
     */
    public function approvedReviews()
    {
        return $this->reviews()->where('status', Review::STATUS_APPROVED);
    }

    /**
     * Get the average rating of the product.
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating');
    }

    /**
     * Get the total number of approved reviews.
     */
    public function getReviewCountAttribute()
    {
        return $this->approvedReviews()->count();
    }
}
