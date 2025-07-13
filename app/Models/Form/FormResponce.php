<?php
// app/Models/FormResponse.php
namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormResponse extends Model
{
    protected $fillable = [
        'form_id',
        'user_id',      // Optional user association
        'is_submitted', // Track if response is complete
        'submitted_at'
    ];

    // Relationship with User (optional)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    // Relationship with Form
    public function form(): BelongsTo
    {
        return $this->belongsTo(BaseForm::class, 'form_id');
    }

    // Relationship with answers
    public function answers(): HasMany
    {
        return $this->hasMany(FormQuestionAnswer::class);
    }

    // Scope to get user's responses
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Method to check if response can be edited
    public function canBeEdited(): bool
    {
        // Add logic to determine if response can be edited
        // For example, check form status, submission time, etc.
        return $this->form->status === 'active' && 
               now()->lessThan($this->form->close_date);
    }
}
