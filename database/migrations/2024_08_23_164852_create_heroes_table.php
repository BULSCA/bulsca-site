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
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('height'); // will end up being a css property such as 100vh or 50% etc
            $table->enum('bg_type', ['image',  'color']);
            $table->string('bg_value')->nullable(); // will be the url of the image or video or the color value
            $table->enum('header_layout', ['vertical', 'horizontal']);
            $table->string('header_title')->default('title');
            $table->string('header_subtitle')->default('subtitle');
            $table->string('header_logo')->default('');
            $table->text('content'); // will contain the rest of the hero content which will most likely be a html snippet

            // activation - all activation types will require the hero to be enabled
            $table->enum('activation_type', ['manual', 'time', 'competition']);
            $table->dateTime('valid_from')->nullable();
            $table->dateTime('valid_to')->nullable();
            $table->boolean('enabled')->default(true);

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
        Schema::dropIfExists('heroes');
    }
};
