<?php

namespace App\Models\Casualty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Casualty\CasualtyGroup;
use App\Models\SERC\SERCTag;
use DB;

class Casualty extends Model
{
    use HasFactory;

    public function getCasualtyGroup()
    {
        return $this->belongsTo(CasualtyGroup::class, 'group');
    }

    public function getImages()
    {
        return $this->hasMany(CasualtyImage::class, 'casualty_id');
    }

    public function getTags()
    {
        $results = DB::select('SELECT DISTINCT name FROM serc_tags st INNER JOIN tagged_casualties tc ON tc.serc_tag_id = st.id WHERE tc.casualty_id = ?', [$this->id]);

        $results = array_map(function ($item) {
            return $item->name;
        }, $results);

        return implode(',', $results);
    }

    public function tags()
    {
        return $this->belongsToMany(SERCTag::class, 'tagged_casualties', 'casualty_id', 'serc_tag_id');
    }
}
