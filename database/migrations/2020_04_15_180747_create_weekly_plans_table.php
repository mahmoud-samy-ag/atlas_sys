<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyPlansTable extends Migration
{
    
    public function up()
    {
        Schema::create('weekly_plans', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->bigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('start_at');
            $table->string('end_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weekly_plans');
    }
}
