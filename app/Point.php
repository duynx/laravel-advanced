<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new \App\Scopes\PointScope());
    }
}
