<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourcePage extends Model
{
    use HasFactory, Orderable;

    public function getSections()
    {
        return $this->hasMany(ResourcePageSection::class, 'page', 'id');
    }
}
