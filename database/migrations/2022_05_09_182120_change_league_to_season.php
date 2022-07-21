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
        Schema::rename('leagues', 'seasons');
        Schema::table('competitions', function(Blueprint $table) {
            $table->renameColumn('league', 'season');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('competitions', function(Blueprint $table) {
            $table->renameColumn('season', 'league');
        });
        Schema::rename('seasons', 'leagues');
    }
};
