<?php

namespace App;

use App\Team;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    protected $perPage = 1000;

    protected $table = 'polygraphy_orders';

    protected $dates = [
        'status_changed_at',
    ];

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
        'ship_time',
        'set_id',
        'received',
        'sorted',
        'docs',
        'set_id',
        'receive_time',
        'in_progress',
        'maket_ok_final',
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
            'fundraising_finished' => 'Нафандрайзили',
            'invoices' => 'Выставлены счета',
            'paid' => 'Оплачено',
            'ordered' => 'Отправлено',
            'production' => 'В производстве',
            'shipped' => 'Доставлено',
            'qa_deliver' => 'QA+Оплата',
            'delivering' => 'В доставке',
            'delivered' => 'Разнесено',
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
            'type' => $this->getOriginal('polygraphy_type'),
            'format' => $this->getOriginal('polygraphy_format'),
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

    public function getCommentAttribute()
    {
        $comment = FlowComment::where(['type' => 'polygraphy_order', 'connected_to' => $this->id])->first();
        if ($comment) {
            return $comment->comment;
        } else {
            return '';
        }
    }

    public function getCommentDeliveryAttribute()
    {
        $comment = FlowComment::where(['type' => 'polygraphy_order_delivery', 'connected_to' => $this->id])->first();
        if ($comment) {
            return $comment->comment;
        } else {
            return '';
        }
    }

    public function getCommentDocsAttribute()
    {
        $comment = FlowComment::where(['type' => 'polygraphy_order_docs', 'connected_to' => $this->id])->first();
        if ($comment) {
            return $comment->comment;
        } else {
            return '';
        }
    }

    public function setCommentAttribute($value)
    {
        $this->saveComment($value, 'polygraphy_order');
    }

    public function setCommentDeliveryAttribute($value)
    {
        $this->saveComment($value, 'polygraphy_order_delivery');
    }

    public function setCommentDocsAttribute($value)
    {
        $this->saveComment($value, 'polygraphy_order_docs');
    }

    /**
     * @param $value
     * @param $type
     */
    private function saveComment($value, $type)
    {
        $comment = FlowComment::where([
            'type' => $type,
            'connected_to' => $this->id
        ])->first();

        if (!$comment) {
            $comment = FlowComment::create([
                'comment_author' => Auth::id(),
                'type' => $type,
                'connected_to' => $this->id,
            ]);
        }

        $comment->comment = $value;
        $comment->save();
    }

    public function scopeWarehouse($query)
    {
        return $query->whereIn('status', ['production', 'shipped', 'delivering', 'qa_deliver', 'delivered']);
    }

    public function responsible()
    {
        return $this->hasOne(User::class, 'id', 's_responsible');
    }

    public function polygraphy_approved()
    {
        return PolygraphyApproved::where([
            'polygraphy_type' => $this->polygraphy_type,
            'team_id' => $this->team_id,
        ])->first();
    }

    public function needCorrections()
    {
        $teamMembers = $this->team()->members()->pluck('id')->toArray();

        $everyoneAgree = PolygraphyPeople::where('polygraphy_type', $this->polygraphy_type)
            ->whereIn('user_id', $teamMembers)
            ->pluck('maket_agree_with')
            ->reduce(function($carry, $item) {
                if ($item == 'false') {
                    $carry = false;
                }
                return $carry;
            }, true);

        return !$everyoneAgree;
    }

    public function getAlarmAttribute()
    {
        if ($this->status !== 'fundraising_finished')
            return false;

        return $this->status_changed_at->diff(Carbon::now())->h >= 23;
    }

    public function getProductionDeadlineAttribute()
    {
        if ($this->status !== 'production')
            return false;

        return $this->status_changed_at->diff(Carbon::now())->h >= 48;
    }

    public function members()
    {
        return $this->polygraphy_approved()->members() ?: $this->team()->members();
    }

    public static function alertCount()
    {
        return static::where('alert', 1)->count();
    }

}
