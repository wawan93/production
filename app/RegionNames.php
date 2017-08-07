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
        })->toArray();
        $regions[0] = '';
        return array_combine($regions, $regions);
    }
}
