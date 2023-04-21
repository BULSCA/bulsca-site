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
        Schema::table('resource_page_section_resources', function (Blueprint $table) {
            $table->integer('ordering')->nullable();
            $table->unique(['ordering', 'section']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resource_page_section_resources', function (Blueprint $table) {
            $table->dropColumn('ordering');
        });
    }
};
