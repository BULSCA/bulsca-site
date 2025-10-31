<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->uuid('code')->unique();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->char('status', 20);
            $table->string('primary_color', 7)->nullable();
            $table->string('secondary_color', 7)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('forms', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        }); 

        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->string('label');               // Question label
            $table->string('type');                // e.g. text, select, checkbox
            $table->json('options')->nullable();   // For select/checkbox types
            $table->boolean('required')->default(false);
            $table->unsignedInteger('field_order')->default(0); // Field order in the form
            $table->unsignedInteger('section')->default(0); // Section number in the form
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('form_fields', function (Blueprint $table) {
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });

        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->uuid('code')->unique();
            $table->unsignedBigInteger('form_id');
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->char('status', 20);
            $table->string('email')->nullable();       
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('submissions', function (Blueprint $table) {
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('submission_fields', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_field_id');
            $table->unsignedBigInteger('submission_id');
            $table->json('answer')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('submission_fields', function (Blueprint $table) {
            $table->foreign('form_field_id')->references('id')->on('form_fields')->onDelete('cascade');
            $table->foreign('submission_id')->references('id')->on('submissions')->onDelete('cascade');
        });

        Schema::create('form_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->integer('section_order')->default(0);
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->json('settings')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('form_sections', function (Blueprint $table) {
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });
    }



    public function down(): void
    {
        Schema::dropIfExists('forms');
        Schema::dropIfExists('form_fields');
        Schema::dropIfExists('submissions');
        Schema::dropIfExists('submission_fields');
        Schema::dropIfExists('form_section');
    }
};

