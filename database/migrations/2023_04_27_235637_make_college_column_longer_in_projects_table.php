<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects',function (Blueprint $table) {
            $table->string('college')->change();
            $table->string('type')->change();
        });
    }

    public function down(): void
    {
        Schema::table('projects',function (Blueprint $table) {
            //
        });
    }
};
