<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Users', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->bigIncrements('userIdx');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('companyName');
            $table->string('businessName');
            $table->string('jobTitle');
            $table->string('password');
            $table->string('passwordKey')->nullable();
            $table->rememberToken();
            $table->decimal('wallet', 10, 2)->nullable();
            $table->tinyInteger('buyerCheck')->nullable();
            $table->tinyInteger('sellerCheck')->nullable();
            $table->tinyInteger('userStatus')->nullable();
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
        Schema::dropIfExists('Users');
    }
}
