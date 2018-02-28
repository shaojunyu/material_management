<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\RadioactiveElement
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string|null $实验室名称
 * @property string|null $实验室负责人
 * @property string|null $负责人手机
 * @property string|null $负责人邮箱
 * @property string|null $保存地点及条件
 * @property string|null $使用场所
 * @property string|null $辐射工作人员持证上岗情况
 * @property string|null $安全防护措施
 * @property string|null $申购理由
 * @property string|null $放射废物处置方案
 * @property string|null $放射性同位素名称
 * @property string|null $放射性同位素活度
 * @property string|null $射线装置名称
 * @property string|null $台数
 * @property string|null $厂家名称
 * @property string|null $辐射许可证编号
 * @property string|null $通讯地址
 * @property string|null $联系人
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $created_at
 * @property string|null $deleted_at
 * @property int|null $user_id
 * @property string|null $status
 * @property string|null $approved_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where使用场所($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where保存地点及条件($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where厂家名称($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where台数($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where安全防护措施($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where实验室名称($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where实验室负责人($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where射线装置名称($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where放射废物处置方案($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where放射性同位素名称($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where放射性同位素活度($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where申购理由($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where联系人($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where负责人手机($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where负责人邮箱($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where辐射工作人员持证上岗情况($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where辐射许可证编号($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\RadioactiveElement where通讯地址($value)
 */
class RadioactiveElement extends Model
{
    protected $table = 'radioactive_element';
}
