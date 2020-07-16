<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddFieldEnquiries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_enquiry', function (Blueprint $table) {
            $table->string('expected_budget')->after('enq_source_type')->nullable();
          });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_enquiry', function (Blueprint $table) {
            $table->dropColumn('expected_budget');
          });
    }
}
