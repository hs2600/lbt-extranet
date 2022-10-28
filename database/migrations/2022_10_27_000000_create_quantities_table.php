<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuantitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quantities', function (Blueprint $table) {
            $table->id();
            $table->string('sku',50);
            $table->string('item',50);
            $table->string('site',50);
            $table->string('bin',20);
            $table->string('lot',10);            
            $table->decimal('qty', $precision = 8, $scale = 2);
            $table->decimal('max_lot_qty', $precision = 8, $scale = 2);
            $table->string('uofm',50);
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
        Schema::dropIfExists('quantities');
    }
}
