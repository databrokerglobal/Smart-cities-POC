<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('UseCases', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('useCaseIdx');
            $table->unsignedBigInteger('offerIdx');
            $table->foreign('offerIdx')->references('offerIdx')->on('Offers');
            $table->string('useCaseDescription');
            $table->text('useCaseContent');
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
        Schema::dropIfExists('UseCases');
    }
}
