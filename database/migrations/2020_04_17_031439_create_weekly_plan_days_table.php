<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyPlanDaysTable extends Migration
{
 
    public function up()
    {
        Schema::create('weekly_plan_days', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->bigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('weekly_plans');
            $table->string('day_date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('start_point')->nullable();
            $table->bigInteger('product_specialist')->nullable();
            $table->foreign('product_specialist')->references('id')->on('users');
            $table->timestamps();
        });
    }

  
    public function down()
    {
        Schema::dropIfExists('weekly_plan_days');
    }
}
