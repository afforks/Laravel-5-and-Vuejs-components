<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Item extends Model
{
    protected $fillable=['name','price','no_of_items','discount','total'];
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('deleted', function (Builder $builder) {
            $builder->where('deleted', '=', 0);
        });

    }
}
