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
        Schema::create('competition_info', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition')->references('id')->on('competitions')->onUpdate('CASCADE')->onDelete('CASCADE');

            $table->integer('max_teams')->default(0);
            $table->text('location')->nullable();

            $table->float('team_cost')->default(0);
            $table->float('social_cost')->default(0);
            $table->float('food_cost')->default(0);
            $table->float('accommodation_cost')->default(0);

            $table->json('isolation_information')->nullable();
            $table->json('pool_information')->nullable();
            $table->json('social_information')->nullable();
            $table->json('accommodation_information')->nullable();
            $table->json('food_information')->nullable();
            $table->json('contact_information')->nullable();

            $table->json('jhb_information')->nullable();

            $table->longText('desc')->nullable();
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
