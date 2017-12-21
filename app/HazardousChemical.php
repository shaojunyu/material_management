<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\HazardousChemicalType;

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
