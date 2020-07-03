<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientdeveloper', function (Blueprint $table) {
            $table->dropColumn('project_id');  
        });

        Schema::table('financier', function (Blueprint $table) {
            $table->dropColumn('project_id');
         
        });

        Schema::table('quantity', function (Blueprint $table) {
            $table->dropColumn('project_id');
         
        });

        Schema::table('mechanical_engg', function (Blueprint $table) {
            $table->dropColumn('project_id');
         
        });


        Schema::table('architact', function (Blueprint $table) {
            $table->dropColumn('project_id');
        });

        Schema::table('interior', function (Blueprint $table) {
            $table->dropColumn('project_id');
          
        });

        Schema::table('contractor', function (Blueprint $table) {
            $table->dropColumn('project_id');
            
        });

        Schema::table('contractor', function (Blueprint $table) {
            $table->dropColumn('project_id');
            
        });

        Schema::table('project', function (Blueprint $table) {
            $table->renameColumn('sub_contractor_id', 'contractor_id');
            $table->renameColumn('main_contractor', 'main_contractor_id');
            
        });
        
    }


    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
