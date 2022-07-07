<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class University extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    protected $guarded = ['id'];


    public function getPage() {
        return $this->hasOne(ClubPage::class, 'uni', 'id');
        
    }

    public function currentUserIsClubAdmin() {
        return (bool) $this->isUserAdmin(auth()->user());
    }

    public function isUserAdmin(User $user) {
        return (bool) DB::table('user_universities')->where('user', $user->id)->where('uni', $this->id)->value('admin');
    }
}
