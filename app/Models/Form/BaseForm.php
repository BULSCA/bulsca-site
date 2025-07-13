<?php
// app/Models/Form/BaseForm.php
namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

abstract class BaseForm extends Model
{
    // Common form properties
    protected $fillable = [
        'title',
        'description',
        'is_user_response_required',
        'close_date',
        'status'
    ];

    // Abstract method to define specific form behavior
    abstract public function getFormType(): string;

    public function questions(): HasMany
    {
        return $this->hasMany(FormQuestion::class, 'form_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(FormResponse::class, 'form_id');
    }
}
