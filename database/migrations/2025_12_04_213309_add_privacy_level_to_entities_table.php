<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->string('privacy_level')->default('public');
        });
    }

    public function down()
    {
        Schema::table('entities', function (Blueprint $table) {
            $table->dropColumn('privacy_level');
        });
    }   
};
