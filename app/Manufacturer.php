<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Manufacturer
 *
 * @property int $id
 * @property string $short_name
 * @property string $full_name
 * @property string|null $full_name_decl
 * @property string $inn
 * @property string $domicile
 * @property string|null $contact
 * @property string $email
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $full_address
 * @property-read mixed $restricted
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer allowedFor($region_name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereDomicile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereFullAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereFullNameDecl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Manufacturer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
    protected $fillable = [
        'short_name', 'full_name', 'full_name_decl', 'inn', 'domicile', 'contact', 'email', 'full_address'
    ];

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
