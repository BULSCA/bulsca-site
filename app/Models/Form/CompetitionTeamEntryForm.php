<?php
// app/Models/Form/Form.php
namespace App\Models\Form;

class CompetitionTeamEntryForm extends BaseForm
{
    // Concrete implementation of abstract method
    public function getFormType(): string
    {
        return 'team_entry';
    }

    public function hostUni()
    {
        return $this->hasOne(University::class, 'id', 'host');
    }

    public function getCompetition()
    {
        return $this->belongsto(Competition::class);
    }
}
