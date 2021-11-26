<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class)->withDefault();
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class)->withDefault();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public static function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public function scopeSearch($query, $search)
    {
        if (empty($search)) {
            return;
        }

        $query->whereRaw('CONCAT(first_name, " ", last_name) like ?', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->orWhereHas('team', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            });

    }

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
