<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uni_org_mapping', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uni_id');
            $table->unsignedBigInteger('organisation_id');
            $table->timestamps();
            
            $table->unique(['uni_id', 'organisation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uni_org_mapping');
    }
};