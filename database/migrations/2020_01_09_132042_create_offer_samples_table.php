<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('OfferSamples', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('sampleIdx');
            $table->unsignedBigInteger('offerIdx');
            $table->text('sampleDescription');
            $table->string('sampleFileName');
            $table->tinyInteger('sampleType');
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
        Schema::dropIfExists('OfferSamples');
    }
}
