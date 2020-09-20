<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoverageVisitingProductsTable extends Migration
{

    public function up()
    {
        Schema::create('coverage_visiting_products', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->bigInteger('report_id')->nullable();
            $table->foreign('report_id')->references('id')->on('daily_reports');
            $table->bigInteger('visiting_id')->nullable();
            $table->foreign('visiting_id')->references('id')->on('coverage_visitings');
            $table->bigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('coverage_visiting_products');
    }
}
