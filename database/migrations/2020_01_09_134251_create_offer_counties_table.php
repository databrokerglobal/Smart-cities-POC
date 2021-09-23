<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OfferCountries', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedBigInteger('regionIdx');
            $table->foreign('regionIdx')->references('regionIdx')->on('Regions');
            $table->unsignedBigInteger('offerIdx');
            $table->foreign('offerIdx')->references('offerIdx')->on('Offers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('OfferCountries');
    }
}
