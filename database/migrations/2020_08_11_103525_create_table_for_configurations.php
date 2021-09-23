<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_title');
            $table->string('favi_icon')->nullable();
            $table->string('logo')->nullable();
            $table->string('footer_logo')->nullable();
            $table->timestamps();
        });

        if (!file_exists('uploads/logo')) {
            mkdir('uploads/logo', 0777, true);
        }

        \DB::table('site_configurations')->insert([
            'site_title'    => 'Welcome to Databroker | The marketplace for data',
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
        Schema::dropIfExists('site_configurations');
    }
}
