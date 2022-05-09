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
        Schema::create('season_unis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season')->nullable()->references('id')->on('seasons')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('uni')->nullable()->references('id')->on('universities')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['season', 'uni']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('season_unis');
    }
};
