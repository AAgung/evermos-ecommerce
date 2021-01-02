<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTCartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_cart', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->nullable()->unique();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->text('product_data')->nullable()->comment('current product data saved in encoded json type');
            $table->decimal('price', 15,2)->default(0.00);
            $table->integer('qty')->default(0);
            $table->timestamps();
        });

        Schema::table('t_cart', function (Blueprint $table) {
            $table->foreign('product_id')->references('id')->on('m_product')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('t_cart', function (Blueprint $table) {
            $table->dropForeign('t_cart_product_id_foreign');
        });
        Schema::dropIfExists('t_cart');
    }
}
