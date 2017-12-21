<?php

namespace App\Http\Controllers;

use App\CommonChemical;
use App\HazardousChemical;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommonChemicalController extends Controller
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
        $data = CommonChemical::offset($size*($page-1))
            ->where('user_id',$user->id)
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }

    public function addChem(Request $request)
    {
        $user = Auth::user();
        $chem = new CommonChemical();
        $inputs = $request->input();
        unset($inputs['_token']);
        $inputs['user_id'] = $user->id;
        $chem->setRawAttributes($inputs);
        if ($chem->save()){
            return JsonResponse::create(['code'=>0,'message'=>'添加成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'添加失败，请重试']);
        }
    }

    public function deleteChem(Request $request)
    {
        $user = Auth::user();
        $chem = CommonChemical::find($request->input('id'));
        if ($chem->user_id != $user->id && !$user->is_admin){
            return JsonResponse::create(['code'=>1,'message'=>'无权限删除']);
        }
        if ($chem->delete())
        {
            return JsonResponse::create(['code'=>0,'message'=>'删除成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'删除失败']);
        }

    }

    public function getDetail(Request $request)
    {
        $user = Auth::user();
        $chem = CommonChemical::find($request->input('id'));
        if ($chem->user_id != $user->id && !$user->is_admin){
            return JsonResponse::create(['code'=>1,'message'=>'无权限查看']);
        }
        return view('chemical.commonChemDetail',['chemical'=>$chem]);
    }

    public function checkIfHazard(Request $request)
    {
        $chem = $request->input('chem');
        $c = HazardousChemical::where('中文名',$chem)
            ->orWhere('别名',$chem)
            ->count();
        if ($c === 0){
            return JsonResponse::create(['code'=>0]);
        }else{
            return JsonResponse::create(['code'=>1,'count'=>$c]);
        }
    }
}
