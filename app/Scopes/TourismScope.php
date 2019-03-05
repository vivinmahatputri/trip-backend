<?php
/**
 * Created by PhpStorm.
 * User: eggy
 * Date: 8/11/18
 * Time: 12:06 PM
 */

namespace App\Scopes;


use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TourismScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
       $builder->where('is_active', true)->has('pictures');
    }
}