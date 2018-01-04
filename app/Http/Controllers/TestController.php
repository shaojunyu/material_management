<?php

namespace App\Http\Controllers;

use App\HazardousChemicalOrder;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $o = HazardousChemicalOrder::find(29);
        return $o;
    }
}
