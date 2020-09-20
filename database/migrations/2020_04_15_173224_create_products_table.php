<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
 
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

 
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
