<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('short_name')->nullable();
            $table->enum('type', ['club', 'league', 'national_body', 'region', 'other']);
            $table->foreignId('parent_id')->nullable()->constrained('organisations')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('county', 100)->nullable();
            $table->string('postcode', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
            
            $table->index('type');
            $table->index('parent_id');
        });

        // Management accounts (owners/admins) - NOT members
        Schema::create('organisation_managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('role', ['owner', 'admin']);
            $table->unique(['organisation_id', 'user_id'], 'org_manager_unique');
            $table->timestamps();
            
            $table->index(['organisation_id', 'role']);
        });

        // Custom committee positions
        Schema::create('organisation_committee_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisation_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('permissions')->nullable();
            $table->timestamps();
            
            $table->unique(['organisation_id', 'title'], 'org_committee_position_unique');
        });

        // Committee members (bridge between users and positions)
        Schema::create('organisation_committee_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('committee_position_id')->constrained('organisation_committee_positions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('appointed_at')->nullable();
            $table->unique(['committee_position_id', 'user_id'], 'org_committee_member_unique');
            $table->timestamps();
            
            $table->index('user_id');
        });

        // Regular members
        Schema::create('organisation_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisation_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->timestamp('joined_at')->nullable();
            $table->unique(['organisation_id', 'user_id'], 'org_member_unique');
            $table->timestamps();
            
            $table->index(['organisation_id', 'status']);
        });

        // Add organisation reference to competitions
        Schema::table('competitions', function (Blueprint $table) {
            $table->foreignId('organisation_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('competitions', function (Blueprint $table) {
            $table->dropConstrainedForeignId('organisation_id');
        });
        Schema::dropIfExists('organisation_members');
        Schema::dropIfExists('organisation_committee_members');
        Schema::dropIfExists('organisation_committee_positions');
        Schema::dropIfExists('organisation_managers');
        Schema::dropIfExists('organisations');
    }
};