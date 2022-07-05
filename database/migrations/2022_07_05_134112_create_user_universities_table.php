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
        Schema::create('user_universities', function (Blueprint $table) {
            $table->foreignId('user')->references('id')->on('users')->onUpdate('CASCADE')->onDelete(('CASCADE'));
            $table->foreignId('uni')->references('id')->on('universities')->onUpdate('CASCADE')->onDelete(('CASCADE'));
            $table->boolean('admin')->default(false);
            $table->unique('user', 'only_one_uni_per_user');
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
        Schema::dropIfExists('user_universities');
    }
};
