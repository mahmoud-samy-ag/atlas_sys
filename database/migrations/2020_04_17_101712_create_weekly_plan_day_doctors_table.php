<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyPlanDayDoctorsTable extends Migration
{
    
    public function up()
    {
        Schema::create('weekly_plan_day_doctors', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->bigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('weekly_plans');
            $table->bigInteger('day_id');
            $table->foreign('day_id')->references('id')->on('weekly_plan_days');
            $table->bigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weekly_plan_day_doctors');
    }
}
