<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function getSlug()
    {
        $title = Str::replace(' ', '-', Str::lower($this->title));
        return "{$title}.{$this->id}";
    }

    public function getDateAuthorString()
    {

        $timePrefix = $this->created_at->lessThan($this->updated_at) ? 'Updated' : 'Published';

        $author = $this->author ? $this->author : 'BULSCA';

        return "{$timePrefix} on {$this->updated_at->format('d/m/Y')} by {$author}";
    }
}
