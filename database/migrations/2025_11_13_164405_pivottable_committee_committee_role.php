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
        Schema::create('committee_committee_role', function (Blueprint $table) {
            $table->foreignId('committee_id')->constrained('committees')->onDelete('cascade');
            $table->foreignId('committee_role_id')->constrained('committee_roles')->onDelete('cascade');
            $table->primary(['committee_id', 'committee_role_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('committee_committee_role');
    }
};
