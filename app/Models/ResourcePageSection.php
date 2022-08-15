<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourcePageSection extends Model
{
    use HasFactory;


    public function getResources() {

        $resIds = ResourcePageSectionResource::where('section', $this->id)->get('resource');

        return Resource::whereIn('id', $resIds)->orderBy('name')->get();
    }


}
