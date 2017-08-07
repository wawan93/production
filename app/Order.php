<?php

namespace App;

use App\Team;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $perPage = 1000;

    protected $table = 'polygraphy_orders';

    protected $fillable = [
        'team_id',
        'code_name',
        'polygraphy_type',
        'manager_id',
        'alert',
        'edition_initial',
        'status',
        'polygraphy_format',
        'edition_final',
        'manufacturer',
        'paid_date',
        'final_date',
        'ship_date',
        'contact',
        'invoice_subject',
        'ship_time'
    ];

    public function team()
    {
        return $this->hasOne(Team::class, 'team_id', 'team_id')->first();
    }

    public function manager()
    {
        $manager = $this->hasOne(User::class, 'id', 'manager_id')->first();
        if ($manager) {
            return $manager;
        } else {
            return new User(['id' => 0]);
        }
    }

    public static function allStatuses()
    {
        $all = [
            '' => '',
            'approved' => 'Согласован',
            'fundraising_finished' => 'Фандрайзинг закончился',
            'invoices' => 'Выставлены счета',
            'paid' => 'Оплачено',
            'production' => 'В производстве',
            'shipped' => 'Доставлено',
            'cancelled' => 'Отменено',
        ];

        return $all;
    }

    public function getStatus()
    {
        $all = static::allStatuses();
        return $all[$this->status];
    }

    public function type()
    {
        return PolygraphyType::where([
            'type' => $this->polygraphy_type,
            'format' => $this->polygraphy_format,
        ])->first();
    }

    public function manufacturer()
    {
        return $this->hasOne(Manufacturer::class, 'id', 'manufacturer')->first();
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'order_id', 'id')->where('direction', 'invoice');
    }

    public function payments()
    {
        return $this->hasMany(Invoice::class, 'order_id', 'id')->where('direction', 'payment');
    }
}
