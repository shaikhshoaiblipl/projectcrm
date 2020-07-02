<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectEnquiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_enquiry', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->UnsignedInteger('project_id');
            $table->Integer('product_category_id')->nullable();
            $table->date('expected_date')->nullable();
            $table->date('received_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('won_loss')->nullable();
            $table->date('quotation_date')->nullable();
            $table->Integer('enq_source')->nullable();
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
        Schema::dropIfExists('project_enquiry');
    }
}
