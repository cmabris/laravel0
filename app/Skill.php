<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public static function getList()
    {
        return Skill::orderBy('name')->get();
    }
}
