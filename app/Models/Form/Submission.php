<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Submission extends Model
{
    use HasFactory;

    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_OPEN = 'open';
    const STATUS_CLOSED = 'closed';

    protected $fillable = [
        'code',
        'form_id',
        'user_id',
        'status',
        'email'
    ];

    public function getRouteKeyName()
    {
        return 'code';
    }

    public function generateCode()
    {
        do {
            $code = (string) Str::uuid();
        } while (self::where('code', $code)->exists());
    
        $this->code = $code;
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function submissionFields()
    {
        return $this->hasMany(SubmissionField::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
