<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourcePageSection extends Model
{
    use HasFactory, Orderable;


    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->setOrderGroupColumn("page");
    }

    public function getResources()
    {

        $resIds = ResourcePageSectionResource::where('section', $this->id)->get('resource');

        return Resource::whereIn('id', $resIds)->orderBy('name')->get();
    }
}
