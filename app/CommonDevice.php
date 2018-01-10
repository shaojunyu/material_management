<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\CommonDevice
 *
 * @mixin \Eloquent
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $品名
 * @property string|null $规格
 * @property string|null $数量
 * @property float|null $单价
 * @property float|null $总金额
 * @property string|null $采购负责人
 * @property string|null $负责人号码
 * @property string|null $采购日期
 * @property string|null $采购单位
 * @property string|null $供应商
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice where供应商($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice where单价($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice where品名($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice where总金额($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice where数量($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice where规格($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice where负责人号码($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice where采购单位($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice where采购日期($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\CommonDevice where采购负责人($value)
 */
class CommonDevice extends Model
{
    //低值设备
    protected $table = 'common_device';
}
