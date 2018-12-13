<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CommonChemical
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $试剂名称
 * @property string|null $规格
 * @property float|null $数量
 * @property float|null $单价
 * @property float|null $总金额
 * @property string|null $申购人姓名
 * @property string|null $申购人号码
 * @property string|null $供应商
 * @property string|null $申报日期
 * @property string|null $申购单位
 * @property string|null $经费负责人
 * @property string|null $经费编号 选填
 * @property string|null $经费名称 选填
 * @property string|null $供应商电话 选填
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $created_at
 * @property int|null $user_id
 * @property string|null $batch_id
 * @property string|null $batch_status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical whereBatchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical whereBatchStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where供应商($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where供应商电话($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where单价($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where总金额($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where数量($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where申报日期($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where申购人号码($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where申购人姓名($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where申购单位($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where经费名称($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where经费编号($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where经费负责人($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where规格($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonChemical where试剂名称($value)
 */
class CommonChemical extends Model
{
    protected $table = 'common_chem';

    public function getUserIdAttribute($value)
    {
        return (int)$value;
    }

}
