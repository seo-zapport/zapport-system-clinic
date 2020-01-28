<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesmedicalSupplyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeesmedical_supply_users', function (Blueprint $table) {
            $table->unsignedBigInteger('employeesmedical_id');
            $table->unsignedBigInteger('supply_id');
            $table->unsignedBigInteger('user_id');
            $table->bigInteger('supqty');
            $table->timestamps();

            $table->foreign('employeesmedical_id')->references('id')->on('employeesmedicals')->onDelete('cascade');
            $table->foreign('supply_id')->references('id')->on('supplies')->onDelete('cascade');
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
        Schema::dropIfExists('employeesmedical_supply_users');
    }
}
