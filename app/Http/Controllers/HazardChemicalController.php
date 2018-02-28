<?php

namespace App\Http\Controllers;

use App\HazardousChemicalInOut;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\HazardousChemical;
use Illuminate\Support\Facades\Auth;

class HazardChemicalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
//        $user = Auth::user();
//        var_dump($user);
//        if ($user->is_admin !== 1){
//            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
//        }
    }

    public function getList(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page');
        $size = $request->input('limit');
        if(!empty($search)){
            $count = HazardousChemical::where('中文名','like',"%$search%")
                ->orWhere('别名','like',"%$search%")
                ->orWhere('CAS','like',"%$search%")
                ->orWhere('备注','like',"%$search%")
                ->orderBy('id', 'desc')
                ->get()
                ->count();
            $data = HazardousChemical::offset($size*($page-1))
                ->where('中文名','like',"%$search%")
                ->orWhere('别名','like',"%$search%")
                ->orWhere('CAS','like',"%$search%")
                ->orWhere('备注','like',"%$search%")
                ->take($size)
                ->orderBy('id', 'desc')
                ->get();
            return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
        }
        $data = HazardousChemical::offset($size*($page-1))
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = HazardousChemical::count();
        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }

    public function addHazardChem(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $hazardChem = new HazardousChemical();
        $hazardChem->setRawAttributes([
            '中文名'=>$request->input('中文名'),
            'CAS'=>$request->input('CAS'),
            'hazardous_type'=>$request->input('hazardous_type'),
            '别名'=>$request->input('别名'),
            '备注'=>$request->input('备注')
        ]);

        if ($hazardChem->save()){
            return JsonResponse::create(['code'=>0,'message'=>'添加成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'添加失败，请重试']);
        }
    }

    public function editHazardChem(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $hazardChem = HazardousChemical::find($request->input('id'));
        return view('chemical.update',['chemical'=>$hazardChem]);
    }

    public function updateHazardChem(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $hazardChem = HazardousChemical::find($request->input('id'));
        $hazardChem->setRawAttributes([
            '中文名'=>$request->input('中文名'),
            'CAS'=>$request->input('CAS'),
            'hazardous_type'=>$request->input('hazardous_type'),
            '别名'=>$request->input('别名'),
            '备注'=>$request->input('备注')
        ]);
        if ($hazardChem->update()){
            return JsonResponse::create(['code'=>0,'message'=>'更新成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'更新失败，请重试']);
        }
    }

    public function deleteHazardChem(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $hazardChem = HazardousChemical::find($request->input('id'));
        if ($hazardChem->delete()){
            return JsonResponse::create(['code'=>0,'message'=>'删除成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'删除失败，请重试']);
        }

    }


    //进出库管理
    public function inTable(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $chem_id = $request->input('chem_id');
        $data = HazardousChemicalInOut::where('chem_id',$chem_id)
            ->where('type','in')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }

    public function outTable(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $chem_id = $request->input('chem_id');
        $data = HazardousChemicalInOut::where('chem_id',$chem_id)
            ->where('type','out')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }

    //入库
    public function addIn(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $in = new HazardousChemicalInOut();
        $in->setRawAttributes([
            '数量'=>$request->input('数量'),
            '存放地'=>$request->input('存放地'),
            '负责人'=>$request->input('负责人'),
            '联系电话'=>$request->input('联系电话'),
            '备注'=>$request->input('备注'),
            'chem_id'=>$request->input('chem_id'),
            'type'=>'in'
        ]);
        if ($in->save()){
            return JsonResponse::create(['code'=>0,'message'=>'添加成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'添加失败，请重试']);
        }
    }

    //出库
    public function addOut(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $out = new HazardousChemicalInOut();
        $out->setRawAttributes([
            '数量'=>$request->input('数量'),
            '存放地'=>$request->input('存放地'),
            '负责人'=>$request->input('负责人'),
            '联系电话'=>$request->input('联系电话'),
            '备注'=>$request->input('备注'),
            'chem_id'=>$request->input('chem_id'),
            'type'=>'out'
        ]);
        if ($out->save()){
            return JsonResponse::create(['code'=>0,'message'=>'添加成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'添加失败，请重试']);
        }
    }

    public function deleteIn(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $in = HazardousChemicalInOut::find($request->input('id'));
        if ($in->delete()){
            return JsonResponse::create(['code'=>0,'message'=>'删除成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'删除成功，请重试']);
        }
    }

    public function deleteOut(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $out = HazardousChemicalInOut::find($request->input('id'));
        if ($out->delete()){
            return JsonResponse::create(['code'=>0,'message'=>'删除成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'删除成功，请重试']);
        }
    }
}
