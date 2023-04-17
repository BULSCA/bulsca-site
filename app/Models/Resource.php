<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory, Uuids;


    public function getURL()
    {
        return '/resources/view/' . $this->id;
    }

    public function getPageResource()
    {
        return $this->hasOne(ResourcePageSectionResource::class, 'resource', 'id');
    }
}
