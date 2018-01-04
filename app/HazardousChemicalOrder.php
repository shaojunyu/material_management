<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\HazardousChemicalOrderItem;

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
