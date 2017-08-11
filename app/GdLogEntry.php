<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\GdLogEntry
 *
 * @property int $id
 * @property string $type
 * @property int $user_id
 * @property int $arg_id
 * @property string $ip
 * @property string $details
 * @property string|null $details2
 * @property string $tg_bot_status
 * @property string $date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GdLogEntry whereArgId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GdLogEntry whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GdLogEntry whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GdLogEntry whereDetails2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GdLogEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GdLogEntry whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GdLogEntry whereTgBotStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GdLogEntry whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\GdLogEntry whereUserId($value)
 * @mixin \Eloquent
 */
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
