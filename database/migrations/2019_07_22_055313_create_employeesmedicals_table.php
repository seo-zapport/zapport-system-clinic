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
            $table->string('bodypart_slug');
        });

        Schema::create('diseases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('disease');
            $table->string('disease_slug');
            $table->unsignedBigInteger('bodypart_id');

            $table->foreign('bodypart_id')->references('id')->on('bodyparts')->onDelete('cascade');
        
        });

        Schema::create('diagnoses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('diagnosis');
            $table->unsignedBigInteger('disease_id');

            $table->foreign('disease_id')->references('id')->on('diseases')->onDelete('cascade');

        });

        Schema::create('employeesmedicals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('med_num')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('diagnosis_id')->nullable();
            $table->text('note')->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('seen')->nullable();
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
