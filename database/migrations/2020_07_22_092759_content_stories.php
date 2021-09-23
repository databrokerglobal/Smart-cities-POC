<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContentStories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_stories', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('storyIdx');
            $table->string('year');
            $table->string('title');
            $table->integer('content_id');
            $table->text('description')->nullable();;
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('content_stories');
    }
}
