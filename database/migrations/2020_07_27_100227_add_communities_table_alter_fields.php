<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommunitiesTableAlterFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communities', function(Blueprint $table)
		{
		    $table->text('description')->nullable()->after('communityName');
		    $table->string('image')->nullable()->after('description');
		    $table->integer('status')->nullable()->default(1)->after('image');
                  
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communities', function(Blueprint $table)
		{
	            $table->dropColumn('description');
	            $table->dropColumn('image');
	            $table->dropColumn('status');
           
		});
    }
}
