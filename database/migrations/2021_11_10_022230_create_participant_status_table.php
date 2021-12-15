<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantStatusTable extends Migration
{
    public function up()
    {
        Schema::create('participant_status',function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('current_status');
            $table->boolean('project_prototype');
//            $table->boolean('project_details')->nullable();
            $table->text('project_elaborate')->nullable();
            $table->string('project_title', 128)->nullable();
            $table->string('project_theme', 128)->nullable();
            $table->string('project_status')->nullable();
            $table->boolean('project_ip_generated')->nullable();
            $table->string('project_ip_type')->nullable();
            $table->boolean('project_ip_status')->nullable();
            $table->boolean('project_hackathon_related')->nullable();
            $table->boolean('project_funding_support')->nullable();
            $table->string('project_trl_level', 128)->nullable();
            $table->string('project_video_url', 128)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('participant_status');
    }
}