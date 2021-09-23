<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserActivityLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_activity_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('action_type')->nullable();
            $table->string('action_by')->nullable();
            $table->string('action_date')->nullable();
            $table->string('action_detail')->nullable();
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
        Schema::dropIfExists('user_activity_log');
    }
}
