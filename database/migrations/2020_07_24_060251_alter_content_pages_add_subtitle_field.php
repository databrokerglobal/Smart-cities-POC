<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterContentPagesAddSubtitleField extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_pages', function(Blueprint $table)
		{
		    $table->text('sub_title')->nullable()->after('title');
                  
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('content_pages', function(Blueprint $table)
		{
	            $table->dropColumn('sub_title');
           
		});
    }
}
