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
        Schema::table('club_pages', function (Blueprint $table) {
            $table->string('banner_color')->default("#070660");
            $table->string('banner_text_color')->default("#ffffff");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('club_pages', function (Blueprint $table) {
            $table->dropColumn('banner_color');
            $table->dropColumn('banner_text_color');
        });
    }
};
