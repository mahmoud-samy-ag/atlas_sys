<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{

    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->string('category');
            $table->string('name');
            $table->string('spec')->nullable();
            $table->string('class')->nullable();
            $table->string('hospital_pharmacy_client')->nullable();
            $table->string('hospital_category')->nullable();
            $table->string('visiting_time')->nullable();
            $table->string('period');
            $table->string('kol')->nullable();
            $table->string('approve')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

   
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
