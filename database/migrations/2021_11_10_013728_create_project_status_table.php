<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStatusTable extends Migration
{
    public function up()
    {
        Schema::create('project_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->boolean('development_status');
            $table->text('description')->nullable();
            $table->boolean('mic_support')->nullable();
            $table->boolean('fund_status');
            $table->string('fund_organisation')->nullable();
            $table->string('fund_amount')->nullable();
            $table->date('funding_date')->nullable();
            $table->boolean('funding_support_needed');
            $table->boolean('project_delivery_status');
            $table->string('project_delivered_status');
            $table->boolean('project_implemented_by_ministry')->nullable();
            $table->boolean('mic_support_deploy')->nullable();
            $table->boolean('incubator_status');
            $table->string('name_of_incubator')->nullable();
            $table->string('trl_level', 128)->nullable();
            $table->string('video_url', 128)->nullable();
            $table->boolean('ip_status');
            $table->string('ip_type')->nullable();
            $table->boolean('is_patent_registered')->nullable();
            $table->string('ip_number')->nullable();
            $table->date('date_of_ip_reg')->nullable();
            $table->string('number_of_ip_filed_till_date')->nullable();
            $table->boolean('startup_status');
            $table->string('startup_name', 128)->nullable();
            $table->boolean('company_registration_status')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_cin')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('project_status');
    }
}