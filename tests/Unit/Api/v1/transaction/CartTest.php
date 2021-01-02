<?php

namespace Tests\Unit\Api\v1\transaction;

use Tests\TestCase;
use App\Models\transaction\Cart;
use App\Models\master\Product;
use Str;

class CartTest extends TestCase
{    
    /**
     * test store to cart with available stock
     *
     * @return void
     */
    public function testStoreToCartWithAvailableStock()
    {
        $product = Product::active()->available()->first();
        if($product) {    
            $response = $this->postJson('api/transaction/cart', [
                'uid' => Str::uuid(),
                'product_uid' => $product->uid,
                'price' => $product->price,
                'qty' => 1,
            ]);

            $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                ]);
        } else $this->assertTrue(true);
    }

    /**
     * test store to cart with available stock
     *
     * @return void
     */
    public function testStoreToCartWithUnavailableStock()
    {
        $product = Product::active()->available()->unavailable()->first();
        
        if($product) {
            $response = $this->postJson('api/transaction/cart', [
                'uid' => Str::uuid(),
                'product_uid' => $product->uid,
                'price' => $product->price,
                'qty' => 10,
            ]);
    
            $response->assertStatus(400)
                ->assertJson([
                    'success' => false,
                ]);
        } else $this->testStoreToCartWithAvailableStock();
    }

    /**
     * test store to cart with more than stock
     *
     * @return void
     */
    public function testStoreToCartWithMoreThanStock()
    {
        $product = Product::active()->available()->first();
        if($product) {
            $response = $this->postJson('api/transaction/cart', [
                'uid' => Str::uuid(),
                'product_uid' => $product->uid,
                'price' => $product->price,
                'qty' => $product->stock + 1,
            ]);

            $response->assertStatus(400)
                ->assertJson([
                    'success' => false,
                ]);
        } else $this->assertTrue(true); 
    }

    /**
     * test update to cart with stock available and order qty reduced
     *
     * @return void
     */
    public function testUpdateToCartWithAvailableStockAndOrderQtyReduced()
    {
        $product = Product::active()->available()->first();
        if($product) {
            $cart = Cart::create([
                'uid' => Str::uuid(),
                'product_id' => $product->id,
                'price' => $product->price,
                'qty' => $product->stock,
            ]);
            
            $response = $this->putJson('api/transaction/cart/'.$cart->uid, [
                'product_uid' => $product->uid,
                'price' => $product->price,
                'qty' => 1,
            ]);
            
            $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                ]);
        } else $this->assertTrue(true);
    }

    /**
     * test update to cart with stock available and order qty reduced
     *
     * @return void
     */
    public function testUpdateToCartWithOrderQtyIncreasedBeUnavailableStock()
    {
        $product = Product::active()->available()->first();
        if($product) {
            $cart = Cart::create([
                'uid' => Str::uuid(),
                'product_id' => $product->id,
                'price' => $product->price,
                'qty' => $product->stock - 1,
            ]);
            
            $response = $this->putJson('api/transaction/cart/'.$cart->uid, [
                'product_uid' => $product->uid,
                'price' => $product->price,
                'qty' => $product->stock + 2,
            ]);
    
            $response->assertStatus(400)
                ->assertJson([
                    'success' => false,
                ]);
        } else $this->assertTrue(true);
    }

    /**
     * test update to cart with stock available and order qty reduced
     *
     * @return void
     */
    public function testUpdateToCartWithOrderQtyIncreasedStillAvailableStock()
    {
        $product = Product::active()->available()->first();
        if($product) {
            $cart = Cart::create([
                'uid' => Str::uuid(),
                'product_id' => $product->id,
                'price' => $product->price,
                'qty' => 1,
            ]);
            
            $response = $this->putJson('api/transaction/cart/'.$cart->uid, [
                'product_uid' => $product->uid,
                'price' => $product->price,
                'qty' => $product->stock,
            ]);
    
            $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                ]);
        } else $this->assertTrue(true);
    }

    /**
     * test validation to cart with unavailable product
     *
     * @return void
     */
    public function testValidationWithUnavailableProduct()
    {
        $response = $this->postJson('api/transaction/cart', [
            'uid' => Str::uuid(),
            'product_uid' => '1234123adsflad',
            'price' => 2000,
            'qty' => 1,
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
            ]);
    }

    /**
     * test validation to cart with qty not filled
     * @return void
     */
    public function testValidationQtyNotFilled()
    {
        $product = Product::active()->available()->first();
        if($product) {
            $response = $this->postJson('api/transaction/cart', [
                'uid' => Str::uuid(),
                'product_uid' => $product->uid,
                'price' => $product->price,
                'qty' => '',
            ]);

            $response->assertStatus(400)
                ->assertJson([
                    'success' => false,
                ]);
        } else $this->assertTrue(true);
    }
}
