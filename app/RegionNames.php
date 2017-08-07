<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegionNames extends Model
{
    protected $table = 'region_names';

    public static function forSelect()
    {
        $regions = self::all(['region_name'])->map(function($item) {
            return $item->region_name;
        });
        return array_combine($regions->toArray(), $regions->toArray());
    }
}
