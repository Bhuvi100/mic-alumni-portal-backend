<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users',function (Blueprint $table) {
            $table->after('role', function ($table){
                $table->enum('employment_status',['Self employed','Salarised Individual'])->nullable();
                $table->enum('degree',['UG','PG','Ph.D'])->nullable();
                $table->string('organization_name')->nullable();
                $table->string('designation')->nullable();
                $table->json('roles_and_expertise')->nullable();
            });
        });
    }

    public function down()
    {
        Schema::table('users',function (Blueprint $table) {
            $table->dropColumn('employment_status');
            $table->dropColumn('degree');
            $table->dropColumn('organization_name');
            $table->dropColumn('designation');
            $table->dropColumn('roles_and_expertise');
        });
    }
}