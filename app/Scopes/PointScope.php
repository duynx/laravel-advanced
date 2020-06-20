<?php
namespace App\Scopes;

use Illumninate\Database\Eloquent\Builder;
use Illumninate\Database\Eloquent\Model;
use Illumninate\Database\Eloquent\Scope;

class PointScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('value', '!=', 16);
    }
}
