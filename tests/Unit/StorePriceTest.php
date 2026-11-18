<?php

namespace Tests\Unit;

use App\Models\Product;
use App\Models\Store;
use Tests\TestCase;

/**
 * State prices: a Maharashtra or West Bengal store shows only that state's wine price,
 * other stores only the retail price; a price that is empty or 0 is not available (NA).
 * The state is matched in any case or spelling.
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
        foreach (['Kolkata', 'kolkata', 'WB', 'W.B.', ' west  bengal ', 'West Bengal', 'WEST BENGAL', 'Calcutta'] as $typed) {
            $this->assertSame('West Bengal', (new Store(['state' => $typed]))->state, $typed);
        }
        foreach (['Mumbai', 'MH', 'maharashtra', 'MAHARASHTRA', 'MaHaRaShTrA', 'Pune'] as $typed) {
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

    public function test_missing_or_zero_price_is_not_available_with_no_fallback(): void
    {
        $kolkata = new Store(['state' => 'West Bengal']);
        $mumbai = new Store(['state' => 'Maharashtra']);
        $goa = new Store(['state' => 'Goa']);

        // State stores never fall back to the retail price
        $this->assertNull($this->wine(1100, null)->priceForStore($kolkata));
        $this->assertNull($this->wine(1100, 0)->priceForStore($kolkata));
        $this->assertNull($this->wine(null, 1200)->priceForStore($mumbai));
        $this->assertNull($this->wine(0, 1200)->priceForStore($mumbai));

        // Other states use the retail price only, and also show NA without one
        $noRetail = $this->wine(1100, 1200)->forceFill(['retail_price' => 0]);
        $this->assertNull($noRetail->priceForStore($goa));
        $this->assertNull($noRetail->priceForStore(null));
    }

    public function test_prices_are_shown_as_rupees_or_na(): void
    {
        $this->assertSame('₹1,234.50', Product::formatPrice(1234.5));
        $this->assertSame('1,234.50', Product::formatPrice('1234.5', ''));
        $this->assertSame('NA', Product::formatPrice(null));
        $this->assertSame('NA', Product::formatPrice(0));
        $this->assertSame('NA', Product::formatPrice('0.00'));
    }

    public function test_price_sql_matches(): void
    {
        $this->assertSame('NULLIF(retail_price_kolkata, 0)', Product::priceSqlForStore(new Store(['state' => 'WB'])));
        $this->assertSame('NULLIF(retail_price_maharashtra, 0)', Product::priceSqlForStore(new Store(['state' => 'mumbai'])));
        $this->assertSame('NULLIF(retail_price, 0)', Product::priceSqlForStore(new Store(['state' => 'Goa'])));
        $this->assertSame('NULLIF(retail_price, 0)', Product::priceSqlForStore(null));
    }
}
