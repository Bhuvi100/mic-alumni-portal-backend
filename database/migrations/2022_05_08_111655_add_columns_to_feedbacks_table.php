<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToFeedbacksTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('feedbacks');

        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('mic_confidence');
            $table->boolean('hired_by_ministry');
            $table->string('hired_by_name')->nullable();
            $table->boolean('helped_placement');
            $table->enum('placement_country', ['India', 'Abroad'])->nullable();
            $table->string('placement_name')->nullable();
            $table->boolean('ministry_internship');
            $table->string('ministry_internship_name')->nullable();
            $table->boolean('helped_internship');
            $table->string('helped_internship_name')->nullable();
            $table->boolean('higher_studies');
            $table->string('higher_studies_degree')->nullable();
            $table->string('higher_studies_stream')->nullable();
            $table->enum('higher_studies_country', ['India', 'Abroad'])->nullable();
            $table->string('helped_higher_studies');
            $table->boolean('received_award');
            $table->string('award_name')->nullable();
            $table->string('award_level')->nullable();
            $table->string('award_state')->nullable();
            $table->string('award_country')->nullable();
            $table->boolean('ip_registration');
            $table->string('ip_type')->nullable();
            $table->string('ip_country')->nullable();
            $table->string('ip_status')->nullable();
            $table->boolean('registered_startup');
            $table->unsignedInteger('registered_startups_count')->nullable();
            $table->boolean('received_investment');
            $table->string('investment_level')->nullable();
            $table->string('recommend_others');
            $table->string('participation_social_awareness');
            $table->text('comments');
            $table->text('improvements');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            //
        });
    }
}