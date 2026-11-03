<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portal_organisations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('kind', 20);
            $table->foreignId('parent_id')->nullable()->constrained('portal_organisations')->restrictOnDelete();
            $table->foreignId('university_id')->nullable()->unique()->constrained('universities')->restrictOnDelete();
            $table->boolean('active')->default(true);
            $table->string('primary_colour', 7)->default('#B1040B');
            $table->string('secondary_colour', 7)->default('#070660');
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
        Schema::create('portal_memberships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisation_id')->constrained('portal_organisations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->unique(['organisation_id', 'user_id']);
            $table->unique(['id', 'organisation_id']);
        });
        Schema::create('portal_committees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisation_id')->constrained('portal_organisations')->cascadeOnDelete();
            $table->string('name');
            $table->date('starts_on');
            $table->date('ends_on')->nullable();
            $table->timestamps();
            $table->unique(['id', 'organisation_id']);
        });
        Schema::create('portal_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisation_id')->constrained('portal_organisations')->cascadeOnDelete();
            $table->string('name');
            $table->json('permissions');
            $table->boolean('protected')->default(false);
            $table->timestamps();
            $table->unique(['organisation_id', 'name']);
            $table->unique(['id', 'organisation_id']);
        });
        Schema::create('portal_appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisation_id')->constrained('portal_organisations')->cascadeOnDelete();
            $table->unsignedBigInteger('membership_id');
            $table->unsignedBigInteger('committee_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();
            $table->unique(['membership_id', 'committee_id', 'role_id'], 'portal_appointment_unique');
            $table->foreign(['membership_id', 'organisation_id'], 'portal_appointment_membership_fk')->references(['id', 'organisation_id'])->on('portal_memberships')->cascadeOnDelete();
            $table->foreign(['committee_id', 'organisation_id'], 'portal_appointment_committee_fk')->references(['id', 'organisation_id'])->on('portal_committees')->cascadeOnDelete();
            $table->foreign(['role_id', 'organisation_id'], 'portal_appointment_role_fk')->references(['id', 'organisation_id'])->on('portal_roles')->restrictOnDelete();
        });
        Schema::create('portal_audit_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organisation_id')->constrained('portal_organisations')->cascadeOnDelete();
            $table->foreignId('actor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action', 80);
            $table->json('changes');
            $table->timestamp('created_at');
        });
        DB::table('portal_organisations')->insert(['name' => 'BULSCA', 'slug' => 'bulsca', 'kind' => 'association', 'active' => true, 'primary_colour' => '#B1040B', 'secondary_colour' => '#070660', 'created_at' => now(), 'updated_at' => now()]);
    }

    public function down(): void
    {
        foreach (['portal_audit_events', 'portal_appointments', 'portal_roles', 'portal_committees', 'portal_memberships', 'portal_organisations'] as $table) Schema::dropIfExists($table);
    }
};
