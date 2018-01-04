<?php

namespace App\Http\Controllers;

use App\CommonDevice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommonDeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getList(Request $request)
    {
        $user = Auth::user();
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = CommonDevice::offset($size*($page-1))
            ->where('user_id',$user->id)
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }

    public function addDevice(Request $request)
    {
        $device = new CommonDevice();
        $inputs = $request->input();
        unset($inputs['_token']);
        $inputs['user_id'] = Auth::user()->id;
        $device->setRawAttributes($inputs);
        if ($device->save())
        {
            return JsonResponse::create(['code'=>0,'message'=>'添加成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'添加失败，请重试']);
        }
    }

    public function deleteDevice(Request $request)
    {
        $user = Auth::user();
        $device = CommonDevice::find($request->input('id'));
        if ($device->user_id != $user->id && !$user->is_admin){
            return JsonResponse::create(['code'=>1,'message'=>'无权限删除']);
        }
        if ($device->delete())
        {
            return JsonResponse::create(['code'=>0,'message'=>'删除成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'删除失败']);
        }
    }

    public function getDetail(Request $request)
    {
        $user = Auth::user();
        $device= CommonDevice::find($request->input('id'));
        if ($device->user_id != $user->id && !$user->is_admin){
            return JsonResponse::create(['code'=>1,'message'=>'无权限查看']);
        }
        return view('chemical.commonChemDetail',['chemical'=>$device]);
    }

    public function allCommonDevices(Request $request)
    {
        $user = Auth::user();
        if (!$user->is_admin){
            return JsonResponse::create('无权访问');
        }
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = CommonDevice::offset($size*($page-1))
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }

    public function downloadDeviceForm(Request $request)
    {
//        var_dump($request->input('ids'));
        $ids = json_decode($request->input('ids'));
        return $ids;
    }
}
