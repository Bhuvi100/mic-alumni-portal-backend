<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumntsToParticipantStatusTable extends Migration
{
    public function up()
    {
        Schema::table('participant_status',function (Blueprint $table) {
            $table->dropColumn('current_status');
            $table->dropColumn('project_prototype');
            $table->dropColumn('project_elaborate');
            $table->text('project_status')->change();
            $table->after('project_ip_status', function($table) {
                $table->string('project_image');
                $table->boolean('project_incubated');
                $table->string('project_incubator_name')->nullable();
                $table->string('project_incubator_city')->nullable();
            });
        });
    }

    public function down()
    {
        Schema::table('participant_status',function (Blueprint $table) {
            //
        });
    }
}