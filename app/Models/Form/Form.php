<?php
// app/Models/Form/Form.php
namespace App\Models\Form;

class Form extends BaseForm
{
    // Concrete implementation of abstract method
    public function getFormType(): string
    {
        return 'generic';
    }
}
