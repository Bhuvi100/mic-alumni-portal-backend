<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('change_makers',function (Blueprint $table) {
            $table->id();
            $table->string('title', 256);
            $table->string('url', 500);
            $table->enum('status', ['live', 'archived']);
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('change_makers');
    }
};
