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
        Schema::create('resource_pages', function (Blueprint $table) {
            $table->id();
            $table->char('name', 100)->unique();
            $table->timestamps();
        });

        Schema::create('resource_page_sections', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->foreignId('page')->nullable()->references('id')->on('resource_pages')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->timestamps();
        });

        Schema::create('resource_page_section_resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section')->nullable()->references('id')->on('resource_page_sections')->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->foreignUuid('resource')->references('id')->on('resources')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->text('short');
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
        Schema::dropIfExists('resource_page_section_resources');
        Schema::dropIfExists('resource_page_sections');
        Schema::dropIfExists('resource_pages');
    }
};
