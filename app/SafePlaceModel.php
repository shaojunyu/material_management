<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\SafePlaceModel
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\SafePlaceModel onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\SafePlaceModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\SafePlaceModel withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $user_id
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $deleted_at
 * @property string|null $address
 * @property string|null $building
 * @property string|null $room
 * @property string|null $cabinet
 * @property string|null $remark
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SafePlaceModel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SafePlaceModel whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SafePlaceModel whereCabinet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SafePlaceModel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SafePlaceModel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SafePlaceModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SafePlaceModel whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SafePlaceModel whereRoom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SafePlaceModel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\SafePlaceModel whereUserId($value)
 */
class SafePlaceModel extends Model
{
    use SoftDeletes;
    protected $table = 'safe_place';
    protected $dates = ['deleted_at'];
}
