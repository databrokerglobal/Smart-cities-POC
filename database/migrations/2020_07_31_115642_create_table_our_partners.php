<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableOurPartners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('our_partners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('partner_type')->nullable();
            $table->integer('proud_partner')->default(0);
            $table->string('logo')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('our_partners');
    }
}
