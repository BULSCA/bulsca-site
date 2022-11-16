<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalNotification extends Model
{
    use HasFactory;

    static function getBanner()
    {
        return GlobalNotification::where('type', 'GLOBAL_BANNER')->first();
    }
}
