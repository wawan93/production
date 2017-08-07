<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllowedManufacturers extends Model
{
    protected $table = 'allowed_manufacturer_region';

    protected $fillable = ['manufacturer_id', 'region_name'];

    public $timestamps = false;
}
