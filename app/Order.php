<?php

namespace App;

use App\Team;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = [
		'team_id', 'code_name', 'polygraphy_type', 'manager_id', 'alert', 'edition_initial', 'status', 'polygraphy_format',
		'edition_final', 'manufacturer', 'paid_date', 'final_date', 'ship_date', 'contact'
	];

	public function team() {
		return $this->hasOne(Team::class, 'team_id', 'team_id')->first();
	}

	public function manager() {
		return $this->hasOne(User::class, 'id', 'manager_id')->first();
	}

	public function getStatus() {
		$all = [
			'approved' => 'Согласован',
			'invoices' => 'Выставлены счета',
			'paid' => 'Оплачено',
			'production' => 'В производстве',
			'shipped' => 'Доставлено'
		];
		return $all[$this->status];
	}
}
