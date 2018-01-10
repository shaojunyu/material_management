<?php

namespace App\Http\Controllers;

use App\Batch;
use App\CommonChemical;
use App\HazardousChemical;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Null_;
use PhpOffice\PhpWord\TemplateProcessor;

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
        $data = CommonChemical::offset($size * ($page - 1))
            ->where('user_id', $user->id)
            ->where('batch_id',null)
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code' => 0, 'count' => $count, 'data' => $data]);
    }

    public function addChem(Request $request)
    {
        $user = Auth::user();
        $chem = new CommonChemical();
        $inputs = $request->input();
        unset($inputs['_token']);
        $inputs['user_id'] = $user->id;
        $chem->setRawAttributes($inputs);
        if ($chem->save()) {
            return JsonResponse::create(['code' => 0, 'message' => '添加成功']);
        } else {
            return JsonResponse::create(['code' => 1, 'message' => '添加失败，请重试']);
        }
    }

    public function deleteChem(Request $request)
    {
        $user = Auth::user();
        $chem = CommonChemical::find($request->input('id'));
        if ($chem->user_id != $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限删除']);
        }
        if ($chem->delete()) {
            return JsonResponse::create(['code' => 0, 'message' => '删除成功']);
        } else {
            return JsonResponse::create(['code' => 1, 'message' => '删除失败']);
        }

    }

    public function getDetail(Request $request)
    {
        $user = Auth::user();
        $chem = CommonChemical::find($request->input('id'));
        if ($chem->user_id != $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限查看']);
        }
        return view('chemical.commonChemDetail', ['chemical' => $chem]);
    }

    public function checkIfHazard(Request $request)
    {
        $chem = $request->input('chem');
        $c = HazardousChemical::where('中文名', $chem)
            ->orWhere('别名', $chem)
            ->count();
        if ($c === 0) {
            return JsonResponse::create(['code' => 0]);
        } else {
            return JsonResponse::create(['code' => 1, 'count' => $c]);
        }
    }

    public function allCommonChem(Request $request)
    {
        $user = Auth::user();
        if (!$user->is_admin) {
            return JsonResponse::create('无权访问');
        }
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = CommonChemical::offset($size * ($page - 1))
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code' => 0, 'count' => $count, 'data' => $data]);
    }

    public function downloadForm(Request $request)
    {
        $batch = new Batch();
        $batch->setRawAttributes([
            'type' => "common_chemical",
            'status' => 'submitted',
            'user_id' => Auth::user()->id
        ]);
        $ids = json_decode($request->input('ids'));
        $items = [];
        $total = 0;
        foreach ($ids as $id) {
            $item = CommonChemical::find($id);
            if ($item->user_id !== Auth::user()->id && !Auth::user()->is_admin) {
                continue;
            }
            if($item->batch_id > 0){
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

        $output = '../storage/app/download/普通试剂-批次' .$batch->id. '.docx';
        $output = str_replace('/', DIRECTORY_SEPARATOR, $output);
        $batch->setAttribute('总金额', $total);
        $batch->save();
        foreach ($items as $item){
            $item->setAttribute('batch_id',$batch->id);
            $item->save();
        }
        $templateProcessor->saveAs($output);
        return \response()->download($output);
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

    public function getHistoryList(Request $request)
    {
        $user = Auth::user();
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = Batch::offset($size * ($page - 1))
            ->where('user_id', $user->id)
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = count($data);
        return JsonResponse::create(['code' => 0, 'count' => $count, 'data' => $data]);
    }

    public function batchDelete(Request $request)
    {
        $batch = Batch::find($request->input('id'));
        $user = Auth::user();
        if ($batch->user_id != $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限操作']);
        }
        if ($batch->status === 'done'){
            return JsonResponse::create(['code' => 1, 'message' => '无法删除']);
        }
        if($batch->deleteCommonChemicals() && $batch->delete())
            return JsonResponse::create(['code' => 0, 'message' => '删除成功']);
        return JsonResponse::create(['code' => 1, 'message' => '删除失败']);
    }

    public function batchDownload(Request $request)
    {
        $batch = Batch::find($request->input('id'));
        $user = Auth::user();
        if ($batch->user_id != $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限操作']);
        }
        $items = $batch->chemicals;
        $total = $batch->总金额;
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

        $output = '../storage/app/download/普通试剂-批次' .$batch->id. '.docx';
        $output = str_replace('/', DIRECTORY_SEPARATOR, $output);
        $batch->setAttribute('总金额', $total);
        $batch->save();
        foreach ($items as $item){
            $item->setAttribute('batch_id',$batch->id);
            $item->save();
        }
        $templateProcessor->saveAs($output);
        return \response()->download($output);
    }

}
