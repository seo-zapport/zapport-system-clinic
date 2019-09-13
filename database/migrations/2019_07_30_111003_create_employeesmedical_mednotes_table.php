<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesmedicalMednotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeesmedical_mednotes', function (Blueprint $table) {
            $table->unsignedBigInteger('employeesmedical_id');
            $table->unsignedBigInteger('mednote_id');

            $table->foreign('employeesmedical_id')->references('id')->on('employeesmedicals')->onDelete('cascade');
            $table->foreign('mednote_id')->references('id')->on('mednotes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeesmedical_mednotes');
    }
}
