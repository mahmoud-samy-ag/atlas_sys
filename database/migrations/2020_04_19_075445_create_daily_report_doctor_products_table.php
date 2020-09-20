<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyReportDoctorProductsTable extends Migration
{
  
    public function up()
    {
        Schema::create('daily_report_doctor_products', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->bigInteger('report_id')->nullable();
            $table->foreign('report_id')->references('id')->on('daily_reports');
            $table->bigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->bigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->mediumText('feedback')->nullable();
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('daily_report_doctor_products');
    }
}
