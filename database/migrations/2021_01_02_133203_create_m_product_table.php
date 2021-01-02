<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_product', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->nullable()->unique();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->decimal('price', 15,2)->default(0.00);
            $table->integer('stock')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::table('m_product', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('m_product_category')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('m_product_unit')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_product', function (Blueprint $table) {
            $table->dropForeign('m_product_category_id_foreign');
            $table->dropForeign('m_product_unit_id_foreign');
        });
        Schema::dropIfExists('m_product');
    }
}
