<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PolygraphyType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'polygraphy_types';

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
    protected $fillable = ['type', 'format', 'mat_name', 'mat_descr', 'order_code', 'mat_type'];

    public static function typesEmoji()
    {
        return [
            '' => '',
            'first_listovka' => '📖',
            'newspaper1' => '🗞',
            'snagroll' => '👥',
            'postcard' => '🖼',
        ];
    }


}
