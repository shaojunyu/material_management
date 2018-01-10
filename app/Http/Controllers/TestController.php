<?php

namespace App\Http\Controllers;

use App\HazardousChemicalOrder;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $o = HazardousChemicalOrder::find(30);
        return $o;
        return get_class($o);
    }
}
