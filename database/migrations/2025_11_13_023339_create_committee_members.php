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
        Schema::create('committee_members', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('committee_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('affiliated_uni_id')->nullable();
            $table->text('name');
            $table->foreign('affiliated_uni_id')->references('id')->on('universities')->onDelete('set null');
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('committee_roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('committee_members');
    }
};
