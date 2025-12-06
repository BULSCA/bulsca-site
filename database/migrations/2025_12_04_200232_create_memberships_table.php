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
        Schema::create('memberships', function (Blueprint $table) {
            $table->uuid('parent_entity_id');
            $table->uuid('child_entity_id');
            $table->string('role')->default('member');
            $table->timestamps();

            $table->foreign('parent_entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('child_entity_id')->references('id')->on('entities')->onDelete('cascade');

            $table->unique(['child_entity_id']); // One membership at a time
        });   
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
