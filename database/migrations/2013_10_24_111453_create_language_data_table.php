<?php

use Illuminate\Database\Migrations\Migration;

class CreateLanguageDataTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('language_data', function ($table) {

            $table->increments('id');
            $table->string('type', 255);
            $table->string('lang_data_id')->nullable();
            $table->string('lang',20);
            $table->interger('pairing_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('language_data');
    }
}
