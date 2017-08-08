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

    public static function forSelect()
    {
        $select = static::all(['id', 'short_name'])->pluck('short_name', 'id');
        $select->prepend('не выбран', 0);
        return $select;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $region_name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAllowedFor($query, $region_name)
    {
        $restricted = AllowedManufacturers::where('region_name', $region_name)
            ->get()
            ->pluck('manufacturer_id')
            ->toArray();
        return $query->whereNOtIn('id', $restricted);
    }

    public function getRestrictedAttribute()
    {
        $regions =  $this->hasMany(AllowedManufacturers::class, 'manufacturer_id', 'id')
            ->pluck('region_name','region_name');
        return $regions;
    }

}
