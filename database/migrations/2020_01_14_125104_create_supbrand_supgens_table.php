<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupbrandSupgensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supbrand_supgens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supbrand_id');
            $table->unsignedBigInteger('supgen_id');
            $table->timestamps();

            $table->foreign('supbrand_id')->references('id')->on('supbrands')->onDelete('cascade');
            $table->foreign('supgen_id')->references('id')->on('supgens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supbrand_supgens');
    }
}
