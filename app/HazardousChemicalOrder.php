<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\HazardousChemicalOrderItem;

/**
 * App\HazardousChemicalOrder
 *
 * @property-read mixed $intro
 * @mixin \Eloquent
 * @property string|null $approved_at
 * @property int $id
 * @property int|null $user_id
 * @property string|null $applicant
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $created_at
 * @property string|null $status applying,submitted
 * @property int|null $cellphone
 * @property string|null $申购人姓名
 * @property string|null $申购人手机号
 * @property string|null $申购人身份证号
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder whereApplicant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder whereCellphone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder where申购人姓名($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder where申购人手机号($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrder where申购人身份证号($value)
 */
class HazardousChemicalOrder extends Model
{
    protected $table = 'hazardous_chem_order';

    protected $appends = ['intro'];

    public function getIntroAttribute()
    {
        $items = HazardousChemicalOrderItem::where('order_id',$this->id)
            ->select('中文名')
            ->take(2)
            ->get();
        $intro = '';
        foreach ($items as $item){
            $intro .= $item['中文名'];
        }
        return $intro." 等";
    }
}
