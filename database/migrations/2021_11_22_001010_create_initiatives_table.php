<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitiativesTable extends Migration
{
    public function up()
    {
        Schema::create('initiatives',function (Blueprint $table) {
            $table->id();
            $table->string('hackathon');
            $table->string('edition');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('initiatives');
    }
}