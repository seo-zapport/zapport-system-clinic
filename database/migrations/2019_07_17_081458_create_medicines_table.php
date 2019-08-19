<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('generic_id');
            $table->unsignedBigInteger('user_id');
            // $table->bigInteger('qty_input');
            $table->bigInteger('qty_stock')->nullable();
            $table->date('expiration_date');
            $table->boolean('availability');
            $table->timestamps();

            $table->foreign('brand_id')->references('id')->on('medbrands')->onDelete('cascade');
            $table->foreign('generic_id')->references('id')->on('generics')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines');
    }
}