<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubmissionField extends Model
{
    use HasFactory;

    protected $fillable = ['submission_id', 'form_field_id', 'answer'];

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function field()
    {
        return $this->belongsTo(FormField::class, 'form_field_id');
    }
}
