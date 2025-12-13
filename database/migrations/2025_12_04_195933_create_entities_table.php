<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('entities', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Universal entity_id
            $table->string('entity_type'); // e.g., 'App\\Models\\User', 'App\\Models\\Organisation'
            $table->unsignedBigInteger('entity_ref_id'); // Points to actual user/org ID
            $table->string('custom_id')->unique(); // e.g., USR-123, ORG-456, GOV-789
            $table->timestamps();

            $table->index(['entity_type', 'entity_ref_id']);
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entities');
    }
};

