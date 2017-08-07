<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GdLogEntry extends Model
{
    protected $table = 'main_activityLog';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'user_id',
        'arg_id',
        'ip',
        'details',
        'tg_bot_status',
    ];
}
