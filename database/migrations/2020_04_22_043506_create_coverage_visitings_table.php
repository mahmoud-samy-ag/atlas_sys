<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoverageVisitingsTable extends Migration
{
 
    public function up()
    {
        Schema::create('coverage_visitings', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->bigInteger('report_id')->nullable();
            $table->foreign('report_id')->references('id')->on('daily_reports');
            $table->bigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->timestamps();
        });
    }

  
    public function down()
    {
        Schema::dropIfExists('coverage_visitings');
    }
}
