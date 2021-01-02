<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\master\ProductCategory;
use App\Models\master\ProductUnit;
use App\Models\master\Product;
use App\Models\transaction\Cart;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/**
 * Factory for Product Category
 */
$factory->define(ProductCategory::class, function (Faker $faker) {
    $name = "Category ".$faker->unique()->words(2, true);

    return [
        'uid' => Str::uuid(),
        'name' => $name,
        'slug' => Str::slug($name),
        'active' => 1,
    ];
});

/**
 * Factory for Product Unit
 */
$factory->define(ProductUnit::class, function (Faker $faker) {
    $name = "Category ".$faker->unique()->words(1, true);

    return [
        'uid' => Str::uuid(),
        'name' => $name,
        'slug' => Str::slug($name),
        'active' => 1,
    ];
});

/**
 * Factory for Product Unit
 */
$factory->define(Product::class, function (Faker $faker) {
    $name = "Product ".$faker->unique()->words(2, true);
    $category = $faker->randomElement(ProductCategory::active()->select('id')->get());
    $unit = $faker->randomElement(ProductUnit::active()->select('id')->get());

    return [
        'uid' => Str::uuid(),
        'name' => $name,
        'slug' => Str::slug($name),
        'description' => $faker->text,
        'category_id' => $category ? $category->id : null,
        'unit_id' => $unit ? $unit->id : null,
        'price' => $faker->numberBetween(100, 999) * 1000,
        'stock' => $faker->numberBetween(0, 5),
        'active' => $faker->numberBetween(0, 1),
    ];
});
