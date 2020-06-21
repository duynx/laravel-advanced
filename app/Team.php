<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function getUsersCountAttribute()
    {
        return \DB::table('users')->where('users.team_id', $this->id)->sum('users.id');
    }

    public $appends = ['users_count'];
}
