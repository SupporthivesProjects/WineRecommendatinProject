<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CheeseProduct;

class Store extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_type',
        'store_name',
        'address',
        'contact_number',
        'email',
        'state',
        'licence_type',
        'license_number',
        'group',
        'gst_vat',
        'status',
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
}
