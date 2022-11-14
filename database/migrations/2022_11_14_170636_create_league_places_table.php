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
        Schema::create('league_places', function (Blueprint $table) {
            $table->id();


            $table->foreignId('uni')->references('id')->on('universities')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('comp')->references('id')->on('competitions')->onUpdate('cascade')->onDelete('cascade');
            $table->char('league');
            $table->integer('pos')->nullable();

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
        Schema::dropIfExists('league_places');
    }
};
