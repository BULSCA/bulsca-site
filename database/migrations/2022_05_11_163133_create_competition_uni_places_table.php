<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competition_uni_places', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('season_uni')->references('id')->on('season_unis')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('league_comp')->references('id')->on('league_competitions')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('overal_pos');
            $table->integer('a_pos')->nullable();
            $table->integer('b_pos')->nullable();
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
        Schema::dropIfExists('competition_uni_places');
    }
};
