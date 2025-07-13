<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormQuestionAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('form_question_answers', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('form_response_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            $table->foreignId('form_question_id')
                  ->constrained()
                  ->onDelete('cascade');
            
            // Flexible answer storage
            $table->text('answer_text')->nullable();
            
            // Additional fields for different answer types
            $table->string('answer_type')->nullable(); // text, number, date, etc.
            $table->json('answer_options')->nullable(); // for multiple selections
            
            // Optional: for tracking changes
            $table->boolean('is_edited')->default(false);
            $table->timestamp('edited_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('form_question_answers');
    }
}
