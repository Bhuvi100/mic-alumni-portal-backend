<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects',function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hackathon')->default('Smart India Hackathon');
            $table->string('year', 15);
            $table->string('team_name');
            $table->string('title');
            $table->string('idea_id/team_id')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('leader_id')->constrained('users');
            $table->string('ps_id', 15)->nullable();
            $table->string('ps_code', 15)->nullable();
            $table->string('ps_title')->nullable();
            $table->text('ps_description')->nullable();
            $table->string('type', 15);
            $table->string('theme');
            $table->string('ministry/organisation');
            $table->string('college', 128);
            $table->string('college_state');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}