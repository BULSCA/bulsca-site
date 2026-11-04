<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_site_revisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('revision')->default(0);
            $table->timestamp('updated_at')->nullable();
        });
        DB::table('public_site_revisions')->insert(['id' => 1, 'revision' => 0, 'updated_at' => now()]);
    }

    public function down(): void
    {
        Schema::dropIfExists('public_site_revisions');
    }
};
