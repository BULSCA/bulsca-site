<?php

namespace App\Models\SERC;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SERC extends Model
{
    use HasFactory;

    protected $table = 'sercs';

    public function getTags() {
        $results = DB::select('SELECT DISTINCT name FROM serc_tags st INNER JOIN tagged_sercs ts ON ts.serc_tag_id = st.id WHERE ts.serc_id = ?', [$this->id]);

        $results = array_map(function($item) {
            return $item->name;
        }, $results);

        return implode(',',$results);
    }

    public function getResources() {
        return $this->belongsToMany('App\Models\Resource', 'serc_resources', 'serc_id', 'resource_id');
    }
}
