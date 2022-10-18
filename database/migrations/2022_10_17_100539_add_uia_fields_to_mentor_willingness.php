<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('mentor_willingness',function (Blueprint $table) {
            $table->string('expertise')->nullable();
            $table->string('theme')->nullable();
            $table->string('organization_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('cv')->nullable();
            $table->boolean('participated_in_previous')->nullable();
        });
    }

    public function down()
    {
        Schema::table('mentor_willingness',function (Blueprint $table) {
            $table->string('expertise');
            $table->string('theme');
            $table->dropColumn('organization_name');
            $table->dropColumn('designation');
            $table->dropColumn('cv');
            $table->dropColumn('participated_in_previous');
        });
    }
};
