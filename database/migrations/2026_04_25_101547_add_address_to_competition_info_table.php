<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('competition_info', function (Blueprint $table) {
            $table->foreignId('primary_location_id')
                ->nullable()
                ->constrained('locations')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('competition_info', function (Blueprint $table) {
            $table->dropConstrainedForeignId('primary_location_id');
        });
    }
};