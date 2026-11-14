<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Store;
use Tests\TestCase;

/**
 * State prices: a store in Maharashtra or West Bengal shows that state's wine price
 * (when the wine has one above 0), however the state was typed.
 */
class StorePriceTest extends TestCase
{
    private function wine(?float $maharashtra, ?float $kolkata): Product
    {
        return (new Product())->forceFill([
            'retail_price' => 1000,
            'retail_price_maharashtra' => $maharashtra,
            'retail_price_kolkata' => $kolkata,
        ]);
    }

    public function test_state_spellings_are_saved_as_the_state_name(): void
    {
        foreach (['Kolkata', 'kolkata', 'WB', 'W.B.', ' west  bengal ', 'West Bengal', 'Calcutta'] as $typed) {
            $this->assertSame('West Bengal', (new Store(['state' => $typed]))->state, $typed);
        }
        foreach (['Mumbai', 'MH', 'maharashtra', 'Pune'] as $typed) {
            $this->assertSame('Maharashtra', (new Store(['state' => $typed]))->state, $typed);
        }
        $this->assertSame('Rajasthan', (new Store(['state' => ' Rajasthan ']))->state);
    }

    public function test_price_region_reads_old_spellings_too(): void
    {
        // A store saved before the state names were tidied
        $store = new Store();
        $store->setRawAttributes(['state' => 'kolkata ']);
        $this->assertSame('West Bengal', $store->priceRegion());

        $store->setRawAttributes(['state' => 'Goa']);
        $this->assertNull($store->priceRegion());
    }

    public function test_store_gets_its_state_price(): void
    {
        $wine = $this->wine(1100, 1200);

        $this->assertEquals(1200, $wine->priceForStore(new Store(['state' => 'Kolkata'])));
        $this->assertEquals(1100, $wine->priceForStore(new Store(['state' => 'Maharashtra'])));
        $this->assertEquals(1000, $wine->priceForStore(new Store(['state' => 'Rajasthan'])));
        $this->assertEquals(1000, $wine->priceForStore(null));
    }

    public function test_missing_or_zero_state_price_falls_back_to_the_standard_price(): void
    {
        $kolkata = new Store(['state' => 'West Bengal']);

        $this->assertEquals(1000, $this->wine(null, null)->priceForStore($kolkata));
        $this->assertEquals(1000, $this->wine(null, 0)->priceForStore($kolkata));
    }

    public function test_price_sql_matches(): void
    {
        $this->assertSame('(CASE WHEN retail_price_kolkata > 0 THEN retail_price_kolkata ELSE retail_price END)',
            Product::priceSqlForStore(new Store(['state' => 'WB'])));
        $this->assertSame('retail_price', Product::priceSqlForStore(new Store(['state' => 'Goa'])));
        $this->assertSame('retail_price', Product::priceSqlForStore(null));
    }
}
