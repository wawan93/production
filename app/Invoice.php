<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Invoice
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $data
 * @property string $download_hash_md5
 * @property string $direction
 * @property-read mixed $time_ago
 * @property-read \App\Order $order
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereDownloadHashMd5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invoice whereUserId($value)
 * @mixin \Eloquent
 */
class Invoice extends Model
{
    protected $table = 'polygraphy_invoices';

    protected $dates = ['created_at'];

    protected $fillable = ['user_id', 'order_id', 'download_hash_md5', 'data'];

    public function order()
    {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getTimeAgoAttribute()
    {
        $minutes = abs(\Carbon\Carbon::now()->diffInMinutes($this->created_at));
        $hours = floor($minutes/60) == 0 ? '' : floor($minutes/60) . 'ч ' ;
        $minutes = ceil($minutes % 60) == 0 ? '' : ceil($minutes % 60) . 'мин';
        return $hours . $minutes;
    }
}
