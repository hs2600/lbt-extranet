<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('category',50);
            $table->string('material',50);
            $table->string('series',50);
            $table->string('size',50);
            $table->text('description');
            $table->string('default_Color',50);
                $table->string('default_finish',50);
            $table->date('launch_Date');
            $table->string('img_url',200);
                $table->string('technical_name',45);
            $table->tinyInteger('status');
                $table->timestamps('created_at');
                $table->timestamps('updated_at');
                $table->string('series_desc',45);
                $table->text('size_desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}

