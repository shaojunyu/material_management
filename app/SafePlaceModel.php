<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SafePlaceModel extends Model
{
    use SoftDeletes;
    protected $table = 'safe_place';
    protected $dates = ['deleted_at'];
}
