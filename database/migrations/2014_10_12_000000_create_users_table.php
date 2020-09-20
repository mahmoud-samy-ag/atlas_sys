<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
  
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('job_title')->nullable();
            $table->string('allow_plan')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

 
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
