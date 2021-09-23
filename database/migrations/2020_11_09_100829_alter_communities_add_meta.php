<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCommunitiesAddMeta extends Migration
{
    public function up()
    {
        Schema::table('communities', function(Blueprint $table)
		{
		    $table->string('meta_title')->nullable();
		    $table->longText('meta_desc')->nullable();
                  
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
	            
	            $table->dropColumn('meta_title');
	            $table->dropColumn('meta_desc');
           
		});
    }
}
