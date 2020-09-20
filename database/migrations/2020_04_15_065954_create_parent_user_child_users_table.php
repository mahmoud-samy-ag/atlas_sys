<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParentUserChildUsersTable extends Migration
{
 
    public function up()
    {
        Schema::create('parent_user_child_users', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned(false);
            $table->bigInteger('parent_id');
            $table->foreign('parent_id')->references('id')->on('users');
            $table->bigInteger('child_id');
            $table->foreign('child_id')->references('id')->on('users');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('parent_user_child_users');
    }
}
