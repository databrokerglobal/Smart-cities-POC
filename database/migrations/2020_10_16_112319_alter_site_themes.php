<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterSiteThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_themes', function(Blueprint $table)
		{
		    $table->string('search_button_color')->nullable()->after('secondary_button_color');;
                  
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_themes', function(Blueprint $table)
		{
	            
	            $table->dropColumn('search_button_color');
           
		});
    }
}
