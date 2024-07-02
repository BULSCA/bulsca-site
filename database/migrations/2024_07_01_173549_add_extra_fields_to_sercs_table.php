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
        Schema::table('sercs', function (Blueprint $table) {
            $table->integer('casualties')->nullable();
            $table->string('author')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sercs', function (Blueprint $table) {
            $table->dropColumn('casualties');
            $table->dropColumn('author');
        });
    }
};
