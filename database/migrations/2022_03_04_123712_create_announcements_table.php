<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    public function up()
    {
        Schema::create('announcements',function (Blueprint $table) {
            $table->id();
            $table->string('title', 256);
            $table->text('description')->nullable();
            $table->string('url', 256)->nullable();
            $table->string('attachment', 256)->nullable();
            $table->enum('status', ['live', 'archived']);
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}