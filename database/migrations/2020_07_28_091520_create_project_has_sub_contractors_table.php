<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectHasSubContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_has_sub_contractors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->UnsignedInteger('project_id')->nullable();
            $table->UnsignedInteger('contractor_id')->nullable();
            $table->string('sub_contractor')->nullable();
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
        Schema::dropIfExists('project_has_sub_contractors');
    }
}
