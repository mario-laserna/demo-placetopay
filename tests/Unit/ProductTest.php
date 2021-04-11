<?php

namespace Tests\Unit;

use App\Models\Product\Product;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_products_exists()
    {
        $this->assertDatabaseCount('products', 3);
    }
}
