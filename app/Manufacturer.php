<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'manufacturers';

	/**
	 * The database primary key value.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * Attributes that should be mass-assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['short_name', 'full_name', 'full_name_decl', 'inn', 'domicile', 'contact', 'email'];

	public static function forSelect() {
		$select = static::all(['id', 'short_name'])->toArray();
		$select = array_combine(array_column($select, 'id'), array_column($select, 'short_name'));
		array_push($select,'не выбран');
		return $select;
	}

}
