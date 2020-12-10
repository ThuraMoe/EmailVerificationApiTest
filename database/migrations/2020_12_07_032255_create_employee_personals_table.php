<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_personals', function (Blueprint $table) {
            $table->id();
            $table->string('emp_code',50)->nullable();             
            $table->string('emp_name',200);
            $table->string('nrc_number',40)->nullable();
            $table->string('passport_number',20)->nullable();
            $table->dateTime('dateofbirth')->nullable();        
            $table->string('email',50)->nullable();
            $table->string('phone',50)->nullable();
            $table->string('address',500)->nullable();
            $table->char('gender',1)->nullable();
            $table->tinyInteger('employee_type')->nullable();
            $table->string('password',200);
            $table->timestamp('email_verified_at')->nullable();
            $table->tinyInteger('flag')->default('1')->comment('0:delete;1:active');
            $table->bigInteger('created_emp');
            $table->bigInteger('updated_emp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_personals');
    }
}
