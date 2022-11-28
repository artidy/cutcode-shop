<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Http\Controllers\CartController;
use Database\Factories\ProductFactory;
use Domain\Cart\CartManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        CartManager::fake();
    }

    public function test_it_is_empty_cart()
    {
        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', collect([]));
    }

    public function test_it_is_not_empty_cart()
    {
        $product = ProductFactory::new()->create();
        cart()->add($product);

        $this->get(action([CartController::class, 'index']))
            ->assertOk()
            ->assertViewIs('cart.index')
            ->assertViewHas('items', cart()->items());
    }

    public function test_it_is_added_success()
    {
        $product = ProductFactory::new()->create();
        $quantity = 4;

        $this->assertEquals(0, cart()->count());

        $this->post(action([CartController::class, 'add'], $product),
            ['quantity' => $quantity]
        );

        $this->assertEquals($quantity, cart()->count());
    }

    public function test_it_is_quantity_changed()
    {
        $product = ProductFactory::new()->create();
        $firstQuantity = 1;
        $secondQuantity = 4;

        cart()->add($product, $firstQuantity);

        $this->assertEquals($firstQuantity, cart()->count());

        $this->post(action([CartController::class, 'quantity'], cart()->items()->first()),
            ['quantity' => $secondQuantity]
        );

        $this->assertEquals($secondQuantity, cart()->count());
    }

    public function test_it_is_delete_success()
    {
        $product = ProductFactory::new()->create();

        cart()->add($product);

        $this->assertEquals(1, cart()->count());

        $this->delete(action([CartController::class, 'delete'], cart()->items()->first()));

        $this->assertEquals(0, cart()->count());
    }

    public function test_it_is_truncate_success()
    {
        $product = ProductFactory::new()->create();

        cart()->add($product);

        $this->assertEquals(1, cart()->count());

        $this->delete(action([CartController::class, 'truncate']));

        $this->assertEquals(0, cart()->count());
    }
}
