<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mentor_feedback',function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('mentor_willingness')->cascadeOnDelete();
            $table->boolean('confirm_attended');
            $table->unsignedInteger('days_attended')->nullable();
            $table->string('nodal_center')->nullable();
            $table->string('role')->nullable();
            $table->string('video_link', 255)->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mentor_feedback');
    }
};
