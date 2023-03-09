<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->text('problem')->nullable();
            $table->text('unique')->nullable();
            $table->text('impact')->nullable();
            $table->text('market_size')->nullable();
            $table->string('category')->nullable();
        });
    }

    public function down()
    {
        Schema::table('stories', function (Blueprint $table) {
            //
        });
    }
};
