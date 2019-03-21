<?php

namespace App\Http\Controllers;

use App\HazardousChemicalOrder;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return Auth::user();
    }
}
