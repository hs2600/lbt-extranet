<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PhpParser\Node\NullableType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('customer',8);
            $table->string('ship_to_name',50);
            $table->string('address1',50);
            $table->string('address2',50)->nullable();
            $table->string('city',20);
            $table->string('state',25);
            $table->string('zip',10);
            $table->string('country',25);
            $table->string('phone1',15)->nullable();
            $table->binary('showroom');
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
        Schema::dropIfExists('addresses');
    }
};
