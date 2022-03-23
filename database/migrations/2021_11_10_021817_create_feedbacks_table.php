<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::create('feedbacks',function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->boolean('hired_by_ministry');
            $table->text('hired_by_ministry_elaborate')->nullable();
            $table->boolean('opportunity_status');
            $table->text('opportunity_details')->nullable();
            $table->boolean('recommendation_status');
            $table->text('recommendation_details')->nullable();
            $table->boolean('mic_help');
            $table->boolean('recommend_to_student');
            $table->boolean('mic_participation');
            $table->text('comments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
}