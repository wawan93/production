<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
