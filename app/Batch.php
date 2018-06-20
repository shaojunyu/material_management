<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Batch
 *
 * @property-read mixed $chemicals
 * @property-read mixed $intro
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $type
 * @property int|null $总金额
 * @property string|null $审核说明
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Batch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Batch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Batch whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Batch whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Batch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Batch whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Batch where审核说明($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Batch where总金额($value)
 */
class Batch extends Model
{
    protected $table = 'batch';

    protected $appends = ['chemicals','intro','devices','fuzeren'];

    public function getChemicalsAttribute()
    {
        $chemicals = $this->hasMany('App\CommonChemical','batch_id','id');
        return $chemicals->get();
    }

    public function getIntroAttribute()
    {
        $chemicals = $this->getChemicalsAttribute();
        $devices = $this->getDevicesAttribute();
        $intro = '';
        $i = 0;
        if (count($chemicals) > 0){
            foreach ($chemicals as $chemical){
                $intro .= $chemical['试剂名称'].",";
                $i++;
                if ($i === 2){
                    break;
                }
            }
        }else{
            foreach ($devices as $device){
                $intro .= $device['品名'].",";
                $i++;
                if ($i === 2){
                    break;
                }
            }
        }
        $intro = rtrim($intro,',');
        return $intro.'等';
    }

    public function getDevicesAttribute()
    {
        $devices = $this->hasMany('App\CommonDevice','batch_id','id');
        return $devices->get();
    }

    public function getFuzerenAttribute()
    {
        $u = User::find($this->user_id);
        if ($u->p_id){
            $u2 = User::find($u->p_id);
            return $u2->name;
        }else{
            return $u->name;
        }
    }

    public function deleteCommonChemicals()
    {
        $chemicals = $this->hasMany('App\CommonChemical','batch_id','id');
        if($chemicals->count() === 0)
            return true;
        if($chemicals->delete())
            return true;
        return false;
    }
//
//    public function resolveCommonChemicals()
//    {
//        $chemicals = $this->hasMany('App\CommonChemical','batch_id','id');
//        if($chemicals->count() === 0)
//            return true;
//        foreach ($chemicals as $chem){
//            $chem->batch_id = null;
//            $chem->save();
//        }
//        return true;
//    }

    public function deleteCommonDevices()
    {
        $devices = $this->hasMany('App\CommonDevice','batch_id','id');
        if ($devices->count() === 0)
            return true;
        if ($devices->delete())
            return true;
        return false;
    }

}
