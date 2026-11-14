<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CheeseProduct;
use App\Models\Feature;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_type',
        'store_name',
        'address1',
        'address2',
        'contact_number',
        'city',
        'location',
        'email',
        'state',
        'licence_type',
        'license_number',
        'group',
        'gst_vat',
        'status',
        'template_id',
        'api_key',
        'sandbox_api_key',
    ];

    /**
     * The cheese products that belong to the store.
     */
    public function cheeseProducts()
    {
        return $this->belongsToMany(CheeseProduct::class, 'store_inventory')
            ->withPivot(['quantity', 'is_available']);
    }

    /**
     * Get the users associated with the store.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the products associated with the store.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'store_products')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    /**
     * Get the featured products associated with the store.
     */
    public function featuredProducts()
    {
        return $this->belongsToMany(Product::class, 'featured_products')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function features()
    {
        return $this->belongsToMany(
            Feature::class,
            'store_features'
        )->withPivot('enabled')
        ->withTimestamps();
    }


    public function parentFeatures()
    {
        return $this->belongsToMany(
            Feature::class,
            'store_parent_features'
        )->withPivot('enabled')
        ->withTimestamps();
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }


    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /** States with their own wine prices (products.retail_price_maharashtra / retail_price_kolkata) */
    public const PRICE_REGION_MAHARASHTRA = 'Maharashtra';
    public const PRICE_REGION_WEST_BENGAL = 'West Bengal';

    /**
     * Ways the state is typed in the store form that mean one of those states.
     * Compared in lower case with spaces, dots and dashes removed ("W.B." -> "wb").
     */
    private const STATE_ALIASES = [
        'westbengal' => self::PRICE_REGION_WEST_BENGAL,
        'wb' => self::PRICE_REGION_WEST_BENGAL,
        'bengal' => self::PRICE_REGION_WEST_BENGAL,
        'kolkata' => self::PRICE_REGION_WEST_BENGAL,
        'calcutta' => self::PRICE_REGION_WEST_BENGAL,
        'maharashtra' => self::PRICE_REGION_MAHARASHTRA,
        'maharastra' => self::PRICE_REGION_MAHARASHTRA,
        'mh' => self::PRICE_REGION_MAHARASHTRA,
        'mumbai' => self::PRICE_REGION_MAHARASHTRA,
        'bombay' => self::PRICE_REGION_MAHARASHTRA,
        'pune' => self::PRICE_REGION_MAHARASHTRA,
    ];

    /**
     * "Kolkata", "WB", " west bengal " -> "West Bengal" (and the same for Maharashtra);
     * any other state is returned trimmed, as typed.
     */
    public static function canonicalState(?string $state): ?string
    {
        if ($state === null) {
            return null;
        }
        $key = preg_replace('/[^a-z]/', '', strtolower($state));

        return self::STATE_ALIASES[$key] ?? trim($state);
    }

    /**
     * The state whose wine prices this store uses, or null for the standard retail price.
     */
    public function priceRegion(): ?string
    {
        $state = self::canonicalState($this->state);

        return in_array($state, [self::PRICE_REGION_MAHARASHTRA, self::PRICE_REGION_WEST_BENGAL], true) ? $state : null;
    }

    /** Saved state names are tidied, so "Kolkata" is stored as "West Bengal" */
    public function setStateAttribute($value): void
    {
        $this->attributes['state'] = self::canonicalState($value);
    }
}
