<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FormField extends Model
{
    use HasFactory;

    const TEMPLATES = [
        'short-answer',
        'email',
        'long-answer',
        'checkbox',
        'multiple-choice',
    ];

    protected $fillable = [
        'form_id',
        'label',
        'type',
        'options',
        'required',
        'field_order',
        'section',
    ];

    protected $casts = [
        'options' => 'array',
        'required' => 'boolean',
        'field_order' => 'integer',
        'section' => 'integer',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function section()
    {
        return $this->belongsTo(FormSection::class, 'section', 'id');
    }

    public function answers()
    {
        return $this->hasMany(SubmissionFields::class);
    }
}
