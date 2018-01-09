<?php

namespace App\Http\Controllers;

use App\RadioactiveElement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RadioactiveElementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Request $request)
    {
        $radio = new RadioactiveElement();
        $input = $request->input();
        unset($input['_token']);
        $input['user_id'] = Auth::user()->id;
        $radio->setRawAttributes($input);
        $radio->setAttribute('status','applying');
        if ($radio->save()){
            return JsonResponse::create(['code'=>0,'message'=>'添加成功,请及时下载申报表格，线上审批']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'添加失败，请重试']);
        }
    }

    public function getList(Request $request)
    {
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = RadioactiveElement::where('user_id',Auth::user()->id)
            ->offset($size*($page-1))
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = RadioactiveElement::where('user_id',Auth::user()->id)
            ->count();
        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }

    public function delete(Request $request)
    {
        $user = Auth::user();
        $radio = RadioactiveElement::find($request->input('id'));
        if ($radio->user_id != $user->id && !$user->is_admin){
            return JsonResponse::create(['code'=>1,'message'=>'无权限删除']);
        }
        if ($radio->delete())
        {
            return JsonResponse::create(['code'=>0,'message'=>'删除成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'删除失败']);
        }
    }

    public function edit(Request $request)
    {
        $user = Auth::user();
        $radio = RadioactiveElement::find($request->input('id'));
        if ($radio->user_id != $user->id && !$user->is_admin){
            return JsonResponse::create(['code'=>1,'message'=>'无权限编辑']);
        }
        return view('radioactive.edit',['element'=>$radio]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $radio = RadioactiveElement::find($request->input('id'));
        if ($radio->user_id != $user->id && !$user->is_admin){
            return JsonResponse::create(['code'=>1,'message'=>'无权限编辑']);
        }
        $input = $request->input();
        unset($input['_token']);
        unset($input['id']);
        $radio->setRawAttributes($input);
        if ($radio->save()){
            return JsonResponse::create(['code'=>0,'message'=>'更新成功,请及时下载申报表格，线上审批']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'添加失败，请重试']);
        }
    }

    public function submit(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)){
            $request['status'] = 'submitted';
            $radio = new RadioactiveElement();
            $input = $request->input();
            unset($input['_token']);
            $input['user_id'] = Auth::user()->id;
            $radio->setRawAttributes($input);
            if ($radio->save()){
                return JsonResponse::create(['code'=>0,'message'=>'添加成功,请及时下载申报表格，线上审批']);
            }else{
                return JsonResponse::create(['code'=>1,'message'=>'添加失败，请重试']);
            }
        }else{
            $request['status'] = 'submitted';
            return $this->update($request);
        }
    }

    public function detail(Request $request)
    {
        $user = Auth::user();
        $radio = RadioactiveElement::find($request->input('id'));
        if ($radio->user_id != $user->id && !$user->is_admin){
            return JsonResponse::create(['code'=>1,'message'=>'无权限编辑']);
        }
        return view('radioactive.detail',['element'=>$radio]);
    }

    public function pass()
    {

    }

    public function reject()
    {

    }

    public function downloadForm()
    {

    }
}
