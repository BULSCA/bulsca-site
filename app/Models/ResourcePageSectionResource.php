<?php

namespace App\Models;

use App\Traits\Orderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourcePageSectionResource extends Model
{
    use HasFactory, Orderable;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setOrderGroupColumn('section');
    }

    public function getResource()
    {
        return $this->hasOne(Resource::class, 'id', 'resource');
    }
}
