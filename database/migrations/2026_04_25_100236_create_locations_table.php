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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->decimal('lat', 10, 8);
            $table->decimal('long', 11, 8);
            $table->string('address')->nullable()->default(null);
            $table->string('postcode')->nullable()->default(null);
            $table->string('country')->nullable()->default(null);
            
            // Polymorphic relationship
            $table->morphs('locatable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};