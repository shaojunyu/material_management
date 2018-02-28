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

    public function downloadForm(Request $request)
    {
        $id = $request->input('id');
        $user = Auth::user();
        $radio = RadioactiveElement::find($id);
        if(!$radio){
            return JsonResponse::create(['code' => 1, 'message' => '参数错误']);
        }
        if ($radio->user_id !== $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限']);
        }
        $tmp = '../storage/app/docs/华中科技大学放射性同位素与射线装置申购审批表.docx';
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($tmp);
        $templateProcessor->setValue(
            ['年', '月', '日',
                '实验室名称','实验室负责人','负责人手机','负责人邮箱',
                '保存地点及条件','使用场所','辐射工作人员持证上岗情况','安全防护措施',
                '申购理由','放射废物处置方案','放射性同位素名称','放射性同位素活度',
                '射线装置名称','台数','厂家名称','辐射许可证编号',
                '通讯地址','联系人'
                ],
            [date("Y"), date("m"), date("d"),
                $radio->实验室名称,$radio->实验室负责人,$radio->负责人手机,$radio->负责人邮箱,
                $radio->保存地点及条件,$radio->使用场所,$radio->辐射工作人员持证上岗情况,$radio->安全防护措施,
                $radio->申购理由,$radio->放射废物处置方案,$radio->放射性同位素名称,$radio->放射性同位素活度,
                $radio->射线装置名称,$radio->台数,$radio->厂家名称,$radio->辐射许可证编号,
                $radio->通讯地址,$radio->联系人
                ]);
        $output = '../storage/app/download/放射性元素'.$radio->id."-华中科技大学放射性同位素与射线装置申购审批表.docx";
        $templateProcessor->saveAs($output);
        return response()->download($output);
    }

    public function submittedRadioactive(Request $request)
    {
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = RadioactiveElement::where('status','submitted')
            ->offset($size*($page-1))
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = RadioactiveElement::where('status','submitted')
            ->count();
        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }

    public function approvedRadioactive(Request $request)
    {
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = RadioactiveElement::where('status','done')
            ->offset($size*($page-1))
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = RadioactiveElement::where('status','done')
            ->count();
        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }


    public function approveRadioactive(Request $request)
    {
        $user = Auth::user();
        if (!$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限操作']);
        }
        $radio = RadioactiveElement::find($request->input('id'));
        $radio->status = "done";
        if ($radio->update()){
            return JsonResponse::create(['code' => 0, 'message' => '操作成功']);
        }else{
            return JsonResponse::create(['code' => 1, 'message' => '操作失败，请稍后重试']);
        }
    }
}
