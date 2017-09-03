<?php

namespace App;

use Cache;
use Illuminate\Database\Schema\Grammars\RenameColumn;
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

    protected static $managers = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $guarded = ['password', 'salt'];

    public $timestamps = false;

    public static function managers()
    {
        if (empty(self::$managers)) {
            self::$managers = Cache::remember('laravel_managers', 36000, function() {
                $users = static::where('extra_class', 'like', '%c_orders_manager%')->get();

                $result = [
                    0 => 'нет'
                ];
                foreach ($users as $user) {
                    $result[$user->id] = $user->surname . ' ' . $user->name;
                }
                return $result;
            });
        }

        return self::$managers;
    }

    public function getElectionAttribute() {
        $region_names = $this->hasOne(RegionNames::class, 'region_name', 'region_name')->first();
        return $region_names->election;
    }
}
