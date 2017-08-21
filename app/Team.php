<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model {
    protected $table = 'district_teams';

    protected $primaryKey = 'team_id';

    public static $diplomats;

    public function members()
    {
        return $this->hasMany(User::class, 'team_id', 'team_id')->get();
    }

    public function diplomat()
    {
        if (empty(static::$diplomats)) {
            $url = 'https://mundep.gudkov.ru/ajax/ajax_externalApi.php?';
            $url .= http_build_query([
                'context' => 'get__regionDiplomat',
            ]);

            $res = file_get_contents($url);
            $res = json_decode($res, true);

            static::$diplomats = $res;
        }

        return @static::$diplomats[$this->region_name];
    }
}