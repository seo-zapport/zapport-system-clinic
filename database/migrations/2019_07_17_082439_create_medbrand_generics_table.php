<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedbrandGenericsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medbrand_generics', function (Blueprint $table) {
            $table->unsignedBigInteger('medbrand_id');
            $table->unsignedBigInteger('generic_id');

            $table->foreign('medbrand_id')->references('id')->on('medbrands')->onDelete('cascade');
            $table->foreign('generic_id')->references('id')->on('generics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medbrand_generics');
    }
}
