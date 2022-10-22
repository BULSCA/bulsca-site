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


            $table->time('start_time');
            $table->time('end_time');

            $table->text('organiser')->nullable();


            $table->integer('teams')->default(0);
            $table->decimal('team_cost', 9, 2)->default(0);

            $table->text('registration_location')->nullable();
            $table->text('pool_location')->nullable();
            $table->text('food_social_location')->nullable();
            $table->text('accommodation_location')->nullable();

            $table->text('social_theme')->nullable();

            $table->text('food_info')->nullable();
            $table->decimal('food_price', 9, 2)->default(0);

            $table->decimal('accommodation_price', 9, 2)->default(0);

            $table->text("league_event")->nullable();



            $table->decimal("pool_length", 9, 2)->default(25);
            $table->integer("pool_lanes")->default(8);

            $table->boolean("full_fa_kit")->default(true);
            $table->boolean("travel_fa_kit")->default(true);

            $table->json('timetable')->nullable();
            $table->json('contact_info')->nullable();
            $table->json('official_info')->nullable();
            $table->text('extra_info')->nullable();





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
