<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreManagerUpload extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_manager_name',
        'store_manager_id',
        'invoice_no',
        'customer_name',
        'customer_mobile',
        'product_name',
        'product_price',
        'type',
        'date'
    ];


    public function syncToCheckoutItem()
    {
        \App\Models\CheckoutItem::create(
            $this->getCheckoutItemData()
        );
    }

    public function getCheckoutItemData(): array
    {
        return [

            'checkout_id' => null,

            'product_id' => null,

            'user_id' => null,

            'store_manager_id' => $this->store_manager_id,

            'product_name' => $this->product_name,

            'price' => $this->product_price,

            'quantity' => $this->qty ?: 1,

            'created_at' => $this->date
                ? \Carbon\Carbon::parse($this->date)
                : now(),

            'updated_at' => now()
        ];
    }

}
