<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profession extends Model
{
    use SoftDeletes;

    protected $fillable = ['title'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
