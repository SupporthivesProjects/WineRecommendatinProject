<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'twid',
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
        'retail_price_maharashtra',
        'retail_price_kolkata',
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
        'categories',
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

    public function templates()
    {
        return $this->belongsToMany(
            Template::class,
            'template_products'
        )->withTimestamps();
    }

    /** Price column for each state that has its own prices (see Store::priceRegion()) */
    private const STATE_PRICE_COLUMNS = [
        Store::PRICE_REGION_MAHARASHTRA => 'retail_price_maharashtra',
        Store::PRICE_REGION_WEST_BENGAL => 'retail_price_kolkata',
    ];

    /**
     * The price column a store uses: its state's column (Maharashtra, West Bengal),
     * otherwise retail_price. No store (guests, admins): retail_price.
     */
    public static function priceColumnForStore(?Store $store): string
    {
        return $store ? (self::STATE_PRICE_COLUMNS[$store->priceRegion()] ?? 'retail_price') : 'retail_price';
    }

    /**
     * A price that is not set or is 0 counts as not available (shown as NA). Returns the
     * price, or null when not available. Nothing is changed in the database.
     */
    public static function availablePrice($price)
    {
        return ($price !== null && $price !== '' && is_numeric($price) && (float) $price > 0) ? $price : null;
    }

    /**
     * Price of this wine in the given store: only the store's own price (its state's price
     * for Maharashtra / West Bengal, the retail price elsewhere). There is no fallback to
     * another price; null means not available (NA). Use (float) / ?? 0 for calculations.
     */
    public function priceForStore(?Store $store)
    {
        return self::availablePrice($this->{self::priceColumnForStore($store)});
    }

    /**
     * SQL for the same price priceForStore() returns (NULL when not available), so a listing
     * can filter by it in the database.
     */
    public static function priceSqlForStore(?Store $store): string
    {
        $column = self::priceColumnForStore($store);

        return "NULLIF({$column}, 0)";
    }

    /**
     * Price for screens: "₹1,234.00", or "NA" when the price is not available.
     */
    public static function formatPrice($price, string $prefix = '₹'): string
    {
        $price = self::availablePrice($price);

        return $price === null ? 'NA' : $prefix . number_format((float) $price, 2);
    }

    /**
     * SQL for the same price getDisplayPrice() returns for the logged-in user's store,
     * so a listing can filter by it across all pages in the database.
     */
    public static function displayPriceSql(): string
    {
        return self::priceSqlForStore(auth()->check() ? auth()->user()->store : null);
    }

    /** Price in the logged-in user's store (kiosk pages) */
    public function getDisplayPrice()
    {
        return $this->priceForStore(auth()->check() ? auth()->user()->store : null);
    }


}
