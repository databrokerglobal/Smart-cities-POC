<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterHomeTredningAddOfferID extends Migration
{  
    
    public function up()
    {
        Schema::table('home_trending', function(Blueprint $table)
		{
		    $table->integer('offerIdx')->nullable()->default(0);
                  
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('home_trending', function(Blueprint $table)
		{
	            
	            $table->dropColumn('offerIdx');
           
		});
    }
}
