<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourcePage extends Model
{
    use HasFactory;

    public function getSections() {
        return $this->hasMany(ResourcePageSection::class, 'page', 'id');
    }
}
