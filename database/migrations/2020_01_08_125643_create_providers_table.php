<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Providers', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('providerIdx');
            $table->unsignedBigInteger('userIdx');
            $table->foreign('userIdx')->references('userIdx')->on('Users');
            $table->unsignedBigInteger('regionIdx');
            $table->foreign('regionIdx')->references('regionIdx')->on('Regions');
            $table->string('companyName');
            $table->string('companyURL');
            $table->string('companyLogo');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('Regions_regionIdx')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Providers');
    }
}
