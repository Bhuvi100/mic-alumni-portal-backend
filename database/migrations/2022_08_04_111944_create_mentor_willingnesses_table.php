<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mentor_willingness', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('hackathon')->default('SIH 2022');
            $table->boolean('interested');
            $table->enum('category', ['sw', 'hw'])->nullable();
            $table->string('nodal_center')->nullable();
            $table->string('associate')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mentor_willingness');
    }
};
