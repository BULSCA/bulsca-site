<?php

namespace App\Models\Casualty;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Casualty\CasualtyGroup;
use App\Models\SERC\SERC;
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

    public function getSlug()
    {
        return str_replace(' ', '-', strtolower($this->name)) . '.' . $this->id;
    }

    public function getAssociatedSercs()
    {
        $sercIds = DB::select("SELECT DISTINCT ts.serc_id FROM tagged_casualties tc JOIN tagged_sercs ts ON ts.serc_tag_id=tc.serc_tag_id WHERE tc.casualty_id=?", [$this->id]);

        return SERC::whereIn('id', array_map(function ($item) {
            return $item->serc_id;
        }, $sercIds))->get();
    }
}
