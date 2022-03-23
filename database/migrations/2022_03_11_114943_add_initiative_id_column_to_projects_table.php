<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInitiativeIdColumnToProjectsTable extends Migration
{
    public function up()
    {
        Schema::table('projects',function (Blueprint $table) {
            $table->dropColumn('hackathon');
            $table->dropColumn('year');
            $table->foreignId('initiative_id')->constrained('initiatives')->cascadeOnDelete()->after('id');
        });
    }

    public function down()
    {
        Schema::table('projects',function (Blueprint $table) {
            $table->string('hackathon');
            $table->string('year');
            $table->dropColumn('initiative_id');
        });
    }
}