<?php

namespace App\Models;

use App\Notifications\ForgotPassword;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, CrudTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sso_user_id',
        'name',
        'email',
        'password',
        'auth_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getHomeUni()
    {
        return University::find(DB::table('user_universities')->where('user', $this->id)->value('uni'));
    }



    public function isUniAdmin($uni)
    {
        return (bool) DB::table('user_universities')->where('user', $this->id)->where('uni', $uni)->value('admin');
    }


    // ---------------------------------------------------------------- //
    // -------------- New Organisation/Management System -------------- //

    // Management roles
    public function managedOrganisations()
    {
        return $this->belongsToMany(Organisation::class, 'organisation_managers')
            ->withPivot('role')
            ->withTimestamps();
    }

    // Committee positions
    public function committeePositions()
    {
        return $this->belongsToMany(OrganisationCommitteePosition::class, 'organisation_committee_members')
            ->withPivot('appointed_at')
            ->withTimestamps();
    }

    // Regular memberships
    public function memberOf()
    {
        return $this->belongsToMany(Organisation::class, 'organisation_members')
            ->withPivot(['status', 'joined_at'])
            ->withTimestamps();
    }

    // Check role in organisation
    public function isOwnerOf(Organisation $org): bool
    {
        return $this->managedOrganisations()
            ->where('organisation_id', $org->id)
            ->wherePivot('role', 'owner')
            ->exists();
    }

    public function isAdminOf(Organisation $org): bool
    {
        return $this->managedOrganisations()
            ->where('organisation_id', $org->id)
            ->wherePivot('role', 'admin')
            ->exists();
    }

    public function isManagerOf(Organisation $org): bool
    {
        return $org->isManager($this);
    }
}
