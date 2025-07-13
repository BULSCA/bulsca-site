<?php
namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormQuestionAnswer extends Model
{
    protected $fillable = [
        'form_response_id',
        'form_question_id',
        'answer_text',
        'answer_type',
        'answer_options',
        'is_edited',
        'edited_at'
    ];

    protected $casts = [
        'answer_options' => 'array',
        'is_edited' => 'boolean',
        'edited_at' => 'datetime'
    ];

    // Relationship with FormResponse
    public function response(): BelongsTo
    {
        return $this->belongsTo(FormResponse::class);
    }

    // Relationship with FormQuestion
    public function question(): BelongsTo
    {
        return $this->belongsTo(FormQuestion::class);
    }
}
