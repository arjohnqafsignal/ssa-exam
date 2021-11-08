<?php

namespace App\Models;

use App\Events\UserSaved;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'suffixname',
        'username',
        'email',
        'password',
        'prefixname',
        'photo',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $dispatchesEvents = [
        'saved' => UserSaved::class
    ];

    public function getFullnameAttribute()
    {
        return ucfirst($this->firstname).' '.$this->middle_initial.' '.ucfirst($this->lastname);
    }

    public function getAvatarAttribute()
    {
        return ($this->photo) ? url('/storage/'.$this->photo) : null;
    }

    public function getMiddleinitialAttribute()
    {
        return strtoupper(substr($this->middlename, 0, 1)).'.';
    }

    public function details()
    {
        return $this->hasMany('App\Models\Details');
    }

    public function saveDetails($details)
    {
        $detail = new Detail();

        return $detail->insert($details);
    }
}
