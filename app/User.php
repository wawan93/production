<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	protected $table = 'main_users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public static function managers()
	{
		$users = static::where('extra_class', 'like', '%c_orders_manager%')->get();

		$result = [];
		foreach ($users as $user) {
			$result[$user->id] = $user->surname . ' ' . $user->name;
		}

		return $result;
	}
}
