<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FlowComment
 *
 * @property int $id
 * @property string|null $type
 * @property int $connected_to
 * @property string $call_status
 * @property int $comment_author
 * @property string|null $comment
 * @property string|null $tik_info
 * @property string $tik_date
 * @property string $date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FlowComment whereCallStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FlowComment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FlowComment whereCommentAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FlowComment whereConnectedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FlowComment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FlowComment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FlowComment whereTikDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FlowComment whereTikInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\FlowComment whereType($value)
 * @mixin \Eloquent
 */
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
