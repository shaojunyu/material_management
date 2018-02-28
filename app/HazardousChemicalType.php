<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\HazardousChemicalType
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalType whereName($value)
 */
class HazardousChemicalType extends Model
{
    protected $table = 'hazardous_type';

}
