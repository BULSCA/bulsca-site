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
        Schema::create('casualties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group')->references('id')->on('casualty_groups')->onUpdate('cascade')->onDelete('cascade');
            $table->text('name');
            $table->text('description')->nullable();
            $table->text('manual_reference')->nullable();
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
        Schema::dropIfExists('casualties');
    }
};
