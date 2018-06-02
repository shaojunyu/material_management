<?php

namespace App\Http\Controllers;

use App\Batch;
use App\CommonDevice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;

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
        $data = CommonDevice::offset($size * ($page - 1))
            ->where('user_id', $user->id)
            ->where('batch_id', '=', null)
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code' => 0, 'count' => $count, 'data' => $data]);
    }

    public function addDevice(Request $request)
    {
        $device = new CommonDevice();
        $inputs = $request->input();
        unset($inputs['_token']);
        $inputs['user_id'] = Auth::user()->id;
        $device->setRawAttributes($inputs);
        if ($device->save()) {
            return JsonResponse::create(['code' => 0, 'message' => '添加成功']);
        } else {
            return JsonResponse::create(['code' => 1, 'message' => '添加失败，请重试']);
        }
    }

    public function deleteDevice(Request $request)
    {
        $user = Auth::user();
        $device = CommonDevice::find($request->input('id'));
        if ($device->user_id != $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限删除']);
        }
        if ($device->delete()) {
            return JsonResponse::create(['code' => 0, 'message' => '删除成功']);
        } else {
            return JsonResponse::create(['code' => 1, 'message' => '删除失败']);
        }
    }

    public function getDetail(Request $request)
    {
        $user = Auth::user();
        $device = CommonDevice::find($request->input('id'));
        if ($device->user_id != $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限查看']);
        }
        return view('chemical.commonChemDetail', ['chemical' => $device]);
    }

    public function allCommonDevices(Request $request)
    {
        $user = Auth::user();
        if (!$user->is_admin) {
            return JsonResponse::create('无权访问');
        }
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = CommonDevice::offset($size * ($page - 1))
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code' => 0, 'count' => $count, 'data' => $data]);
    }

    public function NumToCNMoney($num, $mode = true, $sim = true)
    {
        if (!is_numeric($num)) return '含有非数字非小数点字符！';
        $char = $sim ? array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九')
            : array('零', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖');
        $unit = $sim ? array('', '十', '百', '千', '', '万', '亿', '兆')
            : array('', '拾', '佰', '仟', '', '萬', '億', '兆');
        $retval = $mode ? '元' : '点';
        //小数部分
        if (strpos($num, '.')) {
            list($num, $dec) = explode('.', $num);
            $dec = strval(round($dec, 2));
            if ($mode) {
                $retval .= "{$char[$dec['0']]}角{$char[$dec['1']]}分";
            } else {
                for ($i = 0, $c = strlen($dec); $i < $c; $i++) {
                    $retval .= $char[$dec[$i]];
                }
            }
        }
        //整数部分
        $str = $mode ? strrev(intval($num)) : strrev($num);
        for ($i = 0, $c = strlen($str); $i < $c; $i++) {
            $out[$i] = $char[$str[$i]];
            if ($mode) {
                $out[$i] .= $str[$i] != '0' ? $unit[$i % 4] : '';
                if ($i > 1 and $str[$i] + $str[$i - 1] == 0) {
                    $out[$i] = '';
                }
                if ($i % 4 == 0) {
                    $out[$i] .= $unit[4 + floor($i / 4)];
                }
            }
        }
        $retval = join('', array_reverse($out)) . $retval;
        return $retval;
    }

    public function downloadDeviceForm(Request $request)
    {
        $batch = new Batch();
        $batch->setRawAttributes([
            'type' => "common_device",
            'status' => 'submitted',
            'user_id' => Auth::user()->id
        ]);
        $ids = json_decode($request->input('ids'));
        $items = [];
        $total = 0;
        foreach ($ids as $id) {
            $item = CommonDevice::find($id);
            if ($item->user_id !== Auth::user()->id && !Auth::user()->is_admin) {
                continue;
            }
            if ($item->batch_id > 0) {
                continue;
            }
            $item->总金额 = $item->单价 * $item->数量;
            $total += $item->总金额;
            $items[] = $item;
        }
        $tmp = '../storage/app/docs/华中科技大学低值设备验收单.docx';
        $tmp = str_replace('/', DIRECTORY_SEPARATOR, $tmp);
        $templateProcessor = new TemplateProcessor($tmp);
        $templateProcessor->cloneRow('col1', count($items));
        $i = 1;
        foreach ($items as $item) {
            $templateProcessor->setValue('col1#' . $i, $item->试剂名称);
            $templateProcessor->setValue('col2#' . $i, $item->规格);
            $templateProcessor->setValue('col3#' . $i, $item->单价);
            $templateProcessor->setValue('col4#' . $i, $item->数量);
            $templateProcessor->setValue('col5#' . $i, $item->总金额);
            $i = $i + 1;
        }
        $templateProcessor->setValue('采购单位', $item->采购单位);
        $templateProcessor->setValue('供货商', $item->供应商);
        $templateProcessor->setValue('total', $this->NumToCNMoney($total, true, false) . "(￥ $total)");

        $batch->setAttribute('总金额', $total);
        $batch->save();
        foreach ($items as $item) {
            $item->setAttribute('batch_id', $batch->id);
            $item->save();
        }
        $output = '../storage/app/download/低值设备-批次编号' . $batch->id . '.docx';
        $output = str_replace('/', DIRECTORY_SEPARATOR, $output);
        $templateProcessor->saveAs($output);
        return \response()->download($output);
    }

    public function getHistoryList(Request $request)
    {
        $user = Auth::user();
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = Batch::offset($size * ($page - 1))
            ->where('user_id', $user->id)
            ->where('type', '=', 'common_device')
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code' => 0, 'count' => $count, 'data' => $data]);
    }

    public function batchDownload(Request $request)
    {
        $batch = Batch::find($request->input('id'));
        $user = Auth::user();
        if ($batch->user_id != $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限操作']);
        }
        $items = $batch->devices;
        $total = $batch->总金额;
        $tmp = '../storage/app/docs/华中科技大学低值设备验收单.docx';
        if($total >= 1000){
            $tmp = '../storage/app/docs/华中科技大学单价1000元（含）以上实验室材料验收单.docx';
        }
        $tmp = str_replace('/', DIRECTORY_SEPARATOR, $tmp);
        $templateProcessor = new TemplateProcessor($tmp);
        $templateProcessor->cloneRow('col1', count($items));
        $i = 1;
        foreach ($items as $item) {
            $templateProcessor->setValue('col1#' . $i, $item->试剂名称);
            $templateProcessor->setValue('col2#' . $i, $item->规格);
            $templateProcessor->setValue('col3#' . $i, $item->单价);
            $templateProcessor->setValue('col4#' . $i, $item->数量);
            $templateProcessor->setValue('col5#' . $i, $item->总金额);
            $i = $i + 1;
        }
        $templateProcessor->setValue('采购单位', $item->采购单位);
        $templateProcessor->setValue('供货商', $item->供应商);
        $templateProcessor->setValue('total', $this->NumToCNMoney($total, true, false) . "(￥ $total)");

        $output = '../storage/app/download/地址设备-批次编号' . $batch->id . '.docx';
        $output = str_replace('/', DIRECTORY_SEPARATOR, $output);
        $batch->setAttribute('总金额', $total);
        $batch->save();
        foreach ($items as $item) {
            $item->setAttribute('batch_id', $batch->id);
            $item->save();
        }
        $templateProcessor->saveAs($output);
        return \response()->download($output);
    }

    //管理接口
    public function resolveCommonDeviceBatch(Request $request)
    {
        $batch = Batch::find($request->input('id'));
        $user = Auth::user();
        if ($batch->user_id != $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限操作']);
        }
        if ($batch->status === "done"){
            return JsonResponse::create(['code' => 1, 'message' => '无权限操作']);
        }
        $devices = $batch->devices;
        foreach ($devices as $d){
            $d->batch_id = null;
            $d->save();
        }

        if ($batch->delete()){
            return JsonResponse::create(['code' => 0, 'message' => '操作成功']);
        }else{
            return JsonResponse::create(['code' => 1, 'message' => '操作失败，请稍后重试']);
        }
    }

    public function submittedCommonDeviceOrders(Request $request)
    {
        $user = Auth::user();
        if (!$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限操作']);
        }
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = Batch::offset($size * ($page - 1))
            ->where('type','=','common_device')
            ->where('status','submitted')
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = Batch::where('type','=','common_device')
            ->where('status','submitted')
            ->count();
        return JsonResponse::create(['code' => 0, 'count' => $count, 'data' => $data]);
    }

    public function approveDeviceBatch(Request $request)
    {
        $user = Auth::user();
        $batch = Batch::find($request->input('id'));
        if (!$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限操作']);
        }
        $batch->status = "done";
        if ($batch->update()){
            return JsonResponse::create(['code' => 0, 'message' => '操作成功']);
        }else{
            return JsonResponse::create(['code' => 1, 'message' => '操作失败，请稍后重试']);
        }
    }

    public function approvedCommonDeviceOrders(Request $request)
    {
        $user = Auth::user();
        if (!$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限操作']);
        }
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = Batch::offset($size * ($page - 1))
            ->where('type','=','common_device')
            ->where('status','done')
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = Batch::where('type','=','common_device')
            ->where('status','submitted')
            ->count();
        return JsonResponse::create(['code' => 0, 'count' => $count, 'data' => $data]);
    }
}
