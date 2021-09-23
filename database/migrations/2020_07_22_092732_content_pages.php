<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class ContentPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_pages', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('contentIdx');
            $table->string('title');
            $table->text('description')->nullable();;
            $table->timestamps();
        });

        \DB::table('content_pages')->insert([
            'title'    => 'About Us',
            'description'   =>  "DEmp",
            'created_at'=>date('Y-m-d h:i:s'),
            'updated_at'=>date('Y-m-d h:i:s')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_pages');
    }
}
