<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddArchiveColumnToStoriesTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE stories MODIFY COLUMN display ENUM('none', 'mentor', 'alumni', 'archived') DEFAULT 'none'");
    }

    public function down()
    {
        Schema::table('stories', function (Blueprint $table) {
        });
    }
}
