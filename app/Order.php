<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['team_id', 'code_name', 'polygraphy_type','manager_id','alert','edition_initial','status','polygraphy_format','edition_final','manufacturer','paid_date','final_date','ship_date','contact'];
}
