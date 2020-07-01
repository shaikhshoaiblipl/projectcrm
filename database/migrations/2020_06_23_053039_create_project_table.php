<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name')->nullable();
            $table->UnsignedInteger('project_type_id')->nullable();
            $table->date('project_date')->nullable();
            $table->date('commencement_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->Integer('project_budget')->nullable();
            $table->string('developer')->nullable();
            $table->string('project_financier')->nullable();
            $table->Integer('surveyor_qty')->nullable();
            $table->text('commentery')->nullable();
            $table->string('mech_engg')->nullable();
            $table->string('architect')->nullable();
            $table->string('interior')->nullable();
            $table->string('main_contractor')->nullable();
            $table->UnsignedInteger('project_category_id')->nullable();
            $table->UnsignedInteger('sub_contractor_id')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project');
    }
}
