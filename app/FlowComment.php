<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FlowComment extends Model
{
    protected $table = 'flow_comments';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'connected_to',
        'comment',
        'comment_author',
        'call_status',
        'date',
    ];
}
