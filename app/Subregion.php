<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subregion extends Model
{
    protected $table = 'subregions_list';

    protected $primaryKey = 'subregion_id';

    public $timestamps = false;
}
