<?php

use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('settings', function ($table) {

            $table->increments('id');
            $table->text('settings');
            $table->timestamps();
            $table->string('lang', 20);
            $table->string('path', 255)->nullable();
            $table->string('file_name', 255)->nullable();
            $table->integer('file_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('settings');
    }
}
