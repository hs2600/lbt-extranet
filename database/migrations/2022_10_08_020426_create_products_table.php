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
            $table->string('sku',50);
            $table->string('item',50);
            $table->text('description');
            $table->string('material',50);
            $table->string('series',50);
            $table->string('size',50);
            $table->string('color',50);
            $table->string('finish',50);
            $table->string('format',50);
            $table->string('type',50);
            $table->string('site',50);
            $table->decimal('qty', $precision = 8, $scale = 2);
            $table->decimal('max_lot_qty', $precision = 8, $scale = 2);
            $table->string('uofm',50);
            $table->string('img_url',200);
            $table->tinyInteger('status');
            $table->string('tags',100);
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
