<?php

namespace App\Http\Controllers;

use App\HazardousChemicalOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    //页面
    public function index()
    {
        $user = Auth::user();
        return view('home',['user'=>$user]);
    }

    public function commonChemical()
    {
        return view('commonChem');
    }

    public function hazardousChemical(Request $request)
    {
        return view('hazardousChem',['search'=>$request->input('search')]);
    }

    public function HazardousChemicalOrder()
    {
        return view('hazardousChemOrder');
    }

    public function commonDevice()
    {
        return view('commonDevice');
    }

    public function radioactiveElement()
    {
        return view('radioactiveElement');
    }

    //页面
    public function hazardousChemicalManage()
    {
        $user = Auth::user();
        return view('chemicalManage',['user'=>$user]);
    }

    public function hazardousChemicalOrderManage()
    {
        return view('hazardChemOrderManage');
    }

    public function commonChemicalManage()
    {
        return view('commonChemManage');
    }

    public function CommonDeviceManage()
    {
        return view('commonDeviceManage');
    }

    public function RadioactiveElementManage()
    {
        return view('radioactiveElementManage');
    }

    public function userManage()
    {
        return view('userManage');
    }
    //===========================================================
    public function authorised()
    {
        if (Auth::check()){
            return response('')->setStatusCode(200);
        }else{
            return response('')->setStatusCode(401);
        }
    }

    public function changePassword(Request $request)
    {
        $oldPassword = $request->input('oldPassword');
        $newPassword = $request->input('newPassword');
        $user = DB::table('users')
            ->where('id',Auth::user()->id)
            ->get()[0];
        if(!password_verify($oldPassword,$user->password)){
            return view('home',['user'=>$user,'changePassword'=>2]);
        }
        DB::table('users')
            ->where('id',Auth::user()->id)
            ->update(['password'=>bcrypt($newPassword)]);
        return view('home',['user'=>$user,'changePassword'=>1]);
    }



    public function test()
    {
        $user = Auth::user();
        return json_encode($user->getSafeCabinets());
    }

}
