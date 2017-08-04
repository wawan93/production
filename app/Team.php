<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {
	protected $table = 'district_teams';

	public function members()
	{
		return $this->hasMany(User::class, 'team_id', 'team_id')->get();
	}
}