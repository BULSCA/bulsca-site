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
        Schema::table('organisations', function (Blueprint $table) {
            $table->uuid('owner_entity_id')->nullable();
            $table->foreign('owner_entity_id')->references('id')->on('entities')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('organisations', function (Blueprint $table) {
            $table->dropForeign(['owner_entity_id']);
            $table->dropColumn('owner_entity_id');
        });
    }
};
