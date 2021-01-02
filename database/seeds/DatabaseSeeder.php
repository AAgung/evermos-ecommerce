<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\master\ProductCategory::class, 5)->create();
        factory(App\Models\master\ProductUnit::class, 5)->create();
        factory(App\Models\master\Product::class, 10)->create();
    }
}
