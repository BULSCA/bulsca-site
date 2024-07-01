<?php

namespace App\Models\SERC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERCTag extends Model
{
    use HasFactory;

    protected $table = 'serc_tags';

    protected $fillable = ['name'];
}
