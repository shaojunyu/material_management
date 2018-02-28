<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\HazardousChemicalOrderItem
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $order_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $中文名
 * @property string|null $CAS
 * @property string|null $hazardous_type
 * @property string|null $别名
 * @property string|null $拟供货公司名称
 * @property string|null $公司联系人姓名
 * @property string|null $公司联系人电话
 * @property string|null $申购数量
 * @property string|null $危险特性
 * @property string|null $用途
 * @property string|null $存放地点
 * @property string|null $是否满足安全存放条件
 * @property string|null $存储条件 剧毒
 * @property string|null $科研项目名称 剧毒
 * @property string|null $科研项目编号 剧毒
 * @property string|null $hazardousTypeName
 * @property int|null $chem_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem whereCAS($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem whereChemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem whereHazardousType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem whereHazardousTypeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where中文名($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where公司联系人姓名($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where公司联系人电话($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where别名($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where危险特性($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where存储条件($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where存放地点($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where拟供货公司名称($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where是否满足安全存放条件($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where用途($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where申购数量($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where科研项目名称($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\HazardousChemicalOrderItem where科研项目编号($value)
 */
class HazardousChemicalOrderItem extends Model
{
    protected $table = 'hazardous_chem_order_item';
}
