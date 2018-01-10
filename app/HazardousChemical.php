<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\HazardousChemicalType;

/**
 * App\HazardousChemical
 *
 * @property-read mixed $hazardous_type_name
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\HazardousChemical onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\HazardousChemical withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\HazardousChemical withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $CAS
 * @property string|null $中文名
 * @property string|null $别名
 * @property string|null $备注
 * @property int|null $hazardous_type
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemical whereCAS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemical whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemical whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemical whereHazardousType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemical whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemical whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemical where中文名($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemical where别名($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemical where备注($value)
 */
class HazardousChemical extends Model
{
    use SoftDeletes;

    protected $table = 'hazardous_chem';
    protected $appends = ['hazardousTypeName'];
    protected $dates = ['deleted_at'];

    public function hazardousType()
    {
        $a= $this->hasOne('App\HazardousChemicalType');
    }

    public function getHazardousTypeNameAttribute()
    {
        return HazardousChemicalType::find($this->hazardous_type)->name;
//        return $this->hasOne('App\HazardousChemicalType','id','hazardous_type');
    }
}
