<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyReportDoctorsTable extends Migration
{
  
    public function up()
    {
        Schema::create('daily_report_doctors', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->bigInteger('report_id')->nullable();
            $table->foreign('report_id')->references('id')->on('daily_reports');
            $table->bigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->bigInteger('market_feedback_id')->nullable();
            $table->foreign('market_feedback_id')->references('id')->on('market_feedbacks');
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('daily_report_doctors');
    }
}
