<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolygraphyApproved extends Model
{
    protected $table = 'polygraphy_approved';
    protected $fillable = [];
    public $timestamps = false;

    protected $members = null;

    public function members()
    {
        if ($this->members == null) {
            $users = explode(',', $this->members_ids);
            $this->members = User::whereIn('id', $users)->get()->all();
        }
        return $this->members;
    }
}
