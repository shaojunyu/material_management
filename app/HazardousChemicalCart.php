<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\HazardousChemicalCart
 *
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $中文名
 * @property string|null $CAS
 * @property string|null $hazardous_type
 * @property string|null $别名
 * @property int|null $user_id
 * @property int|null $chem_id
 * @property string|null $hazardousTypeName
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalCart whereCAS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalCart whereChemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalCart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalCart whereHazardousType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalCart whereHazardousTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalCart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalCart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalCart whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalCart where中文名($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalCart where别名($value)
 */
class HazardousChemicalCart extends Model
{
    protected $table = 'hazardous_chem_cart';
}
