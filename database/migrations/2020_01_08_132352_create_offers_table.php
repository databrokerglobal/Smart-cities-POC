<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Offers', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('offerIdx');
            $table->unsignedBigInteger('providerIdx');
            $table->foreign('providerIdx')->references('providerIdx')->on('Providers');
            $table->unsignedBigInteger('communityIdx');
            $table->foreign('communityIdx')->references('communityIdx')->on('Communities');
            $table->string('offerTitle');
            $table->text('offerDescription');
            $table->char('themes', 20);
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
        Schema::dropIfExists('Offers');
    }
}
