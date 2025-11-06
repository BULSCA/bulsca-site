<?php

namespace App\Models\SERC;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERCTag extends Model
{
    use HasFactory;

    protected $table = 'serc_tags';

    protected $fillable = ['name'];

    protected $hidden = ['pivot'];

    public function getTotalReferences()
    {
        return DB::select('SELECT COUNT(*) as count FROM tagged_sercs WHERE serc_tag_id=?', [$this->id])[0]->count;
    }
}
