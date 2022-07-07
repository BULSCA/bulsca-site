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
        Schema::create('competitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('host')->nullable()->references('id')->on('universities')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('league')->nullable()->references('id')->on('leagues')->onUpdate('cascade')->onDelete('set null');
            $table->datetime('when');
            $table->boolean('results')->default(false);
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
        Schema::dropIfExists('competitions');
    }
};
