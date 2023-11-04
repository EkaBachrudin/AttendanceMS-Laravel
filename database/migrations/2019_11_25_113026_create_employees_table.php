<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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

            $table->Increments('id')->from(111)->unsigned();
            $table->string('name');
            $table->string('position');
            $table->string('email')->nullable()->unique();
            $table->string('pin_code')->nullable();
            $table->text('permissions')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('employee_users', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('employee_id')->unsigned();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_users', function (Blueprint $table) {

            $table->dropForeign(['user_id']);
            $table->dropForeign(['employee_id']);
        });

        Schema::dropIfExists('employee_users');
        Schema::dropIfExists('employees');
    }
}
