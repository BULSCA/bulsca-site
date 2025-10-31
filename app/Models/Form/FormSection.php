<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class FormSection extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'id',
        'form_id',
        'section_order',
        'title',
        'description',
        'settings'
    ];

    public function form()
    {
        return $this->hasOne(Form::class);
    }

    public function fields()
    {
        return $this->hasMany(FormField::class, 'section', 'id');
    }
}
