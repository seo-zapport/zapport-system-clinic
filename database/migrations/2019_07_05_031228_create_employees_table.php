<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('emp_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('position_id');
            $table->text('profile_img')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthday');
            $table->string('birth_place');
            $table->string('height');
            $table->string('weight');
            $table->string('citizenship');
            $table->string('civil_status');
            $table->string('religion');
            $table->string('present_address');
            $table->string('permanent_address');
            $table->string('contact');
            $table->boolean('gender');
            // Education
            $table->text('elementary');
            $table->date('elementary_grad_date');
            $table->text('highschool');
            $table->date('highschool_grad_date');
            $table->text('college')->nullable();
            $table->date('college_grad_date')->nullable();
            // Work Experience
            $table->text('experience')->nullable();
            // Siblings
            $table->string('father_name');
            $table->date('father_birthday');
            $table->string('mother_name');
            $table->date('mother_birthday');
            $table->string('spouse_name')->nullable();
            $table->date('date_of_marriage')->nullable();
            $table->text('children')->nullable();
            // notify incase of emergency
            $table->string('person_to_contact');
            $table->string('person_to_contact_address');
            $table->string('person_to_contact_number');
            // Requirements
            $table->string('tin_no')->nullable();
            $table->string('sss_no')->nullable();
            $table->string('philhealth_no')->nullable();
            $table->string('hdmf_no')->nullable();
            $table->date('hired_date');
            $table->boolean('employee_type');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
