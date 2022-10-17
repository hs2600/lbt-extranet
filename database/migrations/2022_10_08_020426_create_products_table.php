<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->string('item');
            $table->string('description');
            $table->string('material');
            $table->string('series');
            $table->string('size');
            $table->string('color');
            $table->string('finish');
            $table->string('format');
            $table->string('type');
            $table->string('site');
            $table->decimal('qty', $precision = 8, $scale = 2);
            $table->string('uofm');
            $table->string('img_url');
            $table->string('status');
            $table->string('tags');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
