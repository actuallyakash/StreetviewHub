<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('status')->nullable();
            $table->string('tags')->nullable();
            $table->string('location_name')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('pano_id')->nullable();
            $table->string('pano_heading')->nullable();
            $table->string('pano_pitch')->nullable();
            $table->string('pano_zoom')->nullable();
            $table->string('media')->nullable();
            $table->unsignedInteger('pioneer')->nullable();
            $table->timestamps();
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
