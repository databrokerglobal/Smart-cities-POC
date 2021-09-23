<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForSiteThemes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_themes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('header_color')->nullable();
            $table->string('footer_color')->nullable();
            $table->string('primary_button_color')->nullable();
            $table->string('secondary_button_color')->nullable();
            $table->string('body_text_size')->nullable();
            $table->string('body_font_family')->nullable();
            $table->integer('status')->default(0);
            $table->integer('updated_by');
            $table->timestamps();
        });

        \DB::table('site_themes')->insert([
            'header_color'    => '#06038D',
            'footer_color'    => '#06038D',
            'primary_button_color'    => '#E15757',
            'secondary_button_color'    => '#9816f4',
            'body_text_size'    => 16,
            'body_font_family'    => 1,
            'status'    => 1,
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
        Schema::dropIfExists('site_themes');
    }
}
