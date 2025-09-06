<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('competition_info');
        Schema::create('competition_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition')->references('id')->on('competitions')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->text('form_entry')->nullable();
            $table->text('form_judges')->nullable();
            $table->text('form_helpers')->nullable();

            $table->json('timetable')->nullable(); // Storing key-value pairs of an item to a timestamp

            $table->text('general_location')->nullable();
            $table->text('general_league_event')->nullable();
            $table->text('general_required_kit')->nullable();
            $table->boolean('general_fak_full')->default(false);
            $table->boolean('general_fak_travel')->default(false);
            $table->text('general_official_headref')->nullable();
            $table->text('general_official_wetserc')->nullable();
            $table->text('general_official_dryserc')->nullable();

            $table->text('pool_location')->nullable();
            $table->decimal('pool_length')->nullable();
            $table->integer('pool_lanes')->nullable();
            $table->text('pool_extra')->nullable();

            $table->text('registration_location')->nullable();
            $table->text('registration_extra')->nullable();

            $table->decimal('teams_cost', 9, 2)->default(0);
            $table->integer('teams_limit')->default(0);
            $table->text('teams_extra')->nullable();

            $table->decimal('food_cost', 9, 2)->default(0);
            $table->text('food_options')->nullable();

            $table->text('social_location')->nullable();
            $table->decimal('social_cost', 9, 2)->default(0);
            $table->text('social_theme')->nullable();

            $table->text('accom_location')->nullable();
            $table->decimal('accom_cost', 9, 2)->default(0);
            $table->text('accom_extra')->nullable();

            $table->text('contact_organiser_name')->nullable();
            $table->text('contact_organiser_email')->nullable();
            $table->text('contact_organiser_phone')->nullable();

            $table->text('contact_emergency_name')->nullable();
            $table->text('contact_emergency_email')->nullable();
            $table->text('contact_emergency_phone')->nullable();

            $table->longText('extra_info')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competition_info');
    }
};
