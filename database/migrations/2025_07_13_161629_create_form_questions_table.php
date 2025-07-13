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
        Schema::create('form_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->text('question_text');
            $table->enum('question_type', [
                'text', 
                'textarea', 
                'multiple_choice', 
                'checkbox', 
                'dropdown', 
                'date', 
                'number'
            ]);
            
            $table->boolean('is_required')->default(false);
            $table->integer('order')->default(0);
            
            // Optional: for multiple choice, checkboxes, dropdowns
            $table->json('options')->nullable();
            
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
        Schema::dropIfExists('form_questions');
    }
};
