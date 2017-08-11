<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\AllowedManufacturers
 *
 * @property string $region_name
 * @property int $manufacturer_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllowedManufacturers whereManufacturerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\AllowedManufacturers whereRegionName($value)
 * @mixin \Eloquent
 */
class AllowedManufacturers extends Model
{
    protected $table = 'allowed_manufacturer_region';

    protected $fillable = ['manufacturer_id', 'region_name'];

    public $timestamps = false;
}
