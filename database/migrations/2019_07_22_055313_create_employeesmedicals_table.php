<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesmedicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodyparts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bodypart');
        });

        Schema::create('diseases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('disease');
            $table->unsignedBigInteger('bodyparts_id');

            $table->foreign('bodyparts_id')->references('id')->on('bodyparts')->onDelete('cascade');
        
        });

        Schema::create('diagnoses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('diagnosis');
            $table->unsignedBigInteger('disease_id');

            $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');

        });

        Schema::create('employeesmedicals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('diagnosis_id');
            $table->text('note');
            $table->string('status');
            $table->string('remarks');
            $table->boolean('seen');
            $table->string('attachment')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('diagnosis_id')->references('id')->on('diagnoses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeesmedicals');
    }
}
