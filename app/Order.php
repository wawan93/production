<?php

namespace App;

use App\Team;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = [
		'team_id', 'code_name', 'polygraphy_type', 'manager_id', 'alert', 'edition_initial', 'status', 'polygraphy_format',
		'edition_final', 'manufacturer', 'paid_date', 'final_date', 'ship_date', 'contact',
		'invoice_subject'
	];

	public function team() {
		return $this->hasOne(Team::class, 'team_id', 'team_id')->first();
	}

	public function manager() {
		$manager = $this->hasOne(User::class, 'id', 'manager_id')->first();
		if ($manager) {
			return $manager;
		} else {
			return new User(['id'=>0]);
		}
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

	public function getInfo()
	{
		$types = [
			'Листовка «Коптер А3»',
			'Листовка «Коптер А4»',
			'Визитка «Кандидатская Б»',
			'Визитка «Кандидатская Ст»',
			'Листовка «Квадрат»',
			'Газета «Предвыборная»',
			'Афиша «Инфо 3л»',
			'Афиша «Инфо 6л»',
		];
		$descriptions = [
			"Листовка А3\n 1 фальц (пополам до А4)\n Печать: 4+4\n Бумага: 130г +-, мелованная, матовая",
			"Листовка А4\n аналогично, бумага — 90г",
			"Визитка 10х7\n Тираж: от 1000\n 4+4\n 300г, матовая",
			"Визитка 9х5  (на одного кандидата)\n Тираж: от 1000\n 4+4\n 300г матовая",
			"Листовка 14*14",
			"ГАЗЕТА\n 4 полосы (2 листа ~А2 пополам)\n газетная бумага от 45-50г, белая\n печать цветная\n тираж примерный 10к",
			"Афиши длинные 630*297 мм\n Тираж: 10 000 шт — 5,2 р./шт (2016г)\n 4,9 при медленной печати находили",
			"Афиши большие  630*594\n Тираж: 20 000 шт —  9,5-10р/шт (2016г)",
		];

		return [
			'description' => $descriptions[0],
			'type' => $types[0],
		];
	}
}
