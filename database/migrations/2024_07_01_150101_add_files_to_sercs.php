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
        Schema::create('serc_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('serc_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignUuid('resource_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serc_resources');
    }
};
