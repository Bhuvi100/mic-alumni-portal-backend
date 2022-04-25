<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProjectStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_status', function (Blueprint $table) {
            $table->dropColumn('company_cin');
            $table->after('company_name', function ($table){
                $table->string('company_registration_type')->nullable();
                $table->boolean('company_registration_dpiit')->nullable();
                $table->string('company_logo')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_status', function (Blueprint $table) {
            $table->string('company_cin')->nullable();
            $table->dropColumn('company_registration_type');
            $table->dropColumn('company_registration_dpiit');
            $table->dropColumn('company_logo');
        });
    }
}
