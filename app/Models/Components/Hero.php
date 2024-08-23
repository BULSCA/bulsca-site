<?php

namespace App\Models\Components;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hero extends Model
{
    use HasFactory;

    protected $casts = [
        'enabled' => 'boolean',
        'valid_from' => 'datetime',
        'valid_to' => 'datetime',
    ];

    public function background(): string {
        if ($this->bg_type === 'image') {
            return "background-image: url('{$this->bg_value}')";
        } else {
            return "background-color: {$this->bg_value}";
        }
    }


}
