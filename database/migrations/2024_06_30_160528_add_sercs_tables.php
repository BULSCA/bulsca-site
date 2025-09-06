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
        Schema::create('sercs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            $table->date('when');
            $table->string('where');

            $table->timestamps();
        });

        Schema::create('serc_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('tagged_sercs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serc_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('serc_tag_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tagged_sercs');
        Schema::dropIfExists('sercs');
        Schema::dropIfExists('serc_tags');

    }
};
