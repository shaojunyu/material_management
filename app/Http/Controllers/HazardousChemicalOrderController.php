<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\HazardousChemicalOrderItem;
use App\HazardousChemicalOrder;
use App\HazardousChemicalCart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HazardousChemicalOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getOrders(Request $request)
    {
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = HazardousChemicalOrder::offset($size * ($page - 1))
            ->where('user_id', Auth::user()->id)
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = HazardousChemicalOrder::where('user_id', Auth::user()->id)
            ->count();
        foreach ($data as $d) {
            if ($d['status'] === 'applying')
                $d['statusName'] = '正在申请中，请完善信息后提交';
            if ($d['status'] === 'submitted')
                $d['statusName'] = '已提交管理员审核，请注意报送纸质材料';
            if ($d['status'] === 'done')
                $d['statusName'] = '已完成';
        }

        return JsonResponse::create(['code' => 0, 'count' => $count, 'data' => $data]);
    }

    public function getCart()
    {
        $data = HazardousChemicalCart::where('user_id', Auth::user()->id)
            ->get();
        return JsonResponse::create(['code' => 0, 'count' => count($data), 'data' => $data]);
    }

    public function addItemToCart(Request $request)
    {
        foreach ($request->input() as $chem) {
            $count = HazardousChemicalCart::where('chem_id', $chem['id'])
                ->where('user_id', Auth::user()->id)
                ->count();
            if ($count === 0) {
                $item = new HazardousChemicalCart();
                $item->setRawAttributes([
                    '中文名' => $chem['中文名'],
                    'CAS' => $chem['CAS'],
                    'hazardous_type' => $chem['hazardous_type'],
                    'chem_id' => $chem['id'],
                    '别名' => $chem['别名'],
                    'hazardousTypeName' => $chem['hazardousTypeName'],
                    'user_id' => Auth::user()->id
                ]);
                $item->save();
            }
        }
        return JsonResponse::create(['code' => 0, 'message' => '添加成功']);
    }

    public function deleteCartItem(Request $request)
    {
        $user = Auth::user();
        $item = HazardousChemicalCart::find($request->input('id'));
        if ($item->user_id != $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限删除']);
        }
        if ($item->delete()) {
            return JsonResponse::create(['code' => 0, 'message' => '删除成功']);
        } else {
            return JsonResponse::create(['code' => 1, 'message' => '删除失败']);
        }
    }

    public function editOrder(Request $request)
    {
        $user = Auth::user();
        $order = HazardousChemicalOrder::find($request->input('orderId'));
        if ($order->user_id !== $user->id) {
            return [$order->user_id, $user->id];
//            return redirect('HazardousChemicalOrder');
        }
        if ($order->status === 'done' or $order->status === 'submitted')
            return redirect('HazardousChemicalOrder');
        $items = HazardousChemicalOrderItem::where('order_id', $order->id)
            ->get();
        return view('chemical.hazardChemOrderForm', ['items' => $items, 'order' => $order]);
    }

    public function submitCart(Request $request)
    {
        $user = Auth::user();
        $items = HazardousChemicalCart::where('user_id', $user->id)
            ->get();
        if (count($items) === 0) {
            return redirect('HazardousChemicalOrder');
        }
        $order = new HazardousChemicalOrder();
        $order->setRawAttributes([
            'user_id' => $user->id,
            'status' => 'applying'
        ]);
        $order->save();
        //cart item to order item
        foreach ($items as $item) {
            $order_item = new HazardousChemicalOrderItem();
            $order_item->setRawAttributes([
                'order_id' => $order->id,
                '中文名' => $item['中文名'],
                'CAS' => $item['CAS'],
                'hazardous_type' => $item['hazardous_type'],
                '别名' => $item['别名'],
                'chem_id' => $item['chem_id'],
                'hazardousTypeName' => $item['hazardousTypeName']
            ]);
            $order_item->save();
            $item->delete();
        }
        return redirect('editOrder?orderId=' . $order->id);
    }

    public function deleteOrder(Request $request)
    {
        $user = Auth::user();
        $order = HazardousChemicalOrder::find($request->input('id'));
        if ($order->user_id != $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限删除']);
        }
        if ($order->delete()) {
            HazardousChemicalOrderItem::where('order_id', $request->input('id'))
                ->delete();
            return JsonResponse::create(['code' => 0, 'message' => '删除成功']);
        } else {
            return JsonResponse::create(['code' => 1, 'message' => '删除失败']);
        }
    }

    public function storeOrder(Request $request)
    {
        $user = Auth::user();
        $order_id = $request->input('order_id', '');
        $order = HazardousChemicalOrder::find($order_id);
        if ($order->user_id !== $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限修改']);
        }
        $order->setRawAttributes([
            '申购人姓名' => $request->input('申购人姓名'),
            '申购人手机号' => $request->input('申购人手机号'),
            '申购人身份证号' => $request->input('申购人身份证号'),
        ]);
        $order->update();
        $items = HazardousChemicalOrderItem::where('order_id', $order_id)
            ->get();

        foreach ($items as $item) {
            foreach ($item->getAttributes() as $k => $v) {
                if ($request->input($item->id . $k)) {
                    $item->$k = $request->input($item->id . $k);
                }
            }
            $item->update();
        }
        return JsonResponse::create(['code' => 0, 'message' => '保存成功']);
    }

    public function submitOrder(Request $request){
        $user = Auth::user();
        $order_id = $request->input('order_id', '');
        $order = HazardousChemicalOrder::find($order_id);
        if ($order->user_id !== $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限修改']);
        }
        $order->setRawAttributes([
            'status'=>'submitted',
            '申购人姓名' => $request->input('申购人姓名'),
            '申购人手机号' => $request->input('申购人手机号'),
            '申购人身份证号' => $request->input('申购人身份证号'),
        ]);
        $order->update();
        $items = HazardousChemicalOrderItem::where('order_id', $order_id)
            ->get();
        foreach ($items as $item) {
            foreach ($item->getAttributes() as $k => $v) {
                if ($request->input($item->id . $k)) {
                    $item->$k = $request->input($item->id . $k);
                }
            }
            $item->update();
        }
        return JsonResponse::create(['code' => 0, 'message' => '提交成功']);
    }

    public function orderDetail(Request $request)
    {
        $user = Auth::user();
        $order_id = $request->input('order_id', '');
        $order = HazardousChemicalOrder::find($order_id);
        if ($order->user_id !== $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限修改']);
        }
        $items = HazardousChemicalOrderItem::where('order_id', $order->id)
            ->get();
        return view('chemical.hazardChemOrder',['items' => $items, 'order' => $order]);
    }


    //管理接口
    public function allOrders(Request $request)
    {
        $user = Auth::user();
        if (!$user->is_admin){
            return JsonResponse::create('无权访问');
        }
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = HazardousChemicalOrder::offset($size * ($page - 1))
            ->where('status', 'submitted')
            ->orwhere('status', 'done')
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = HazardousChemicalOrder::where('status', 'submitted')
            ->orwhere('status', 'done')
            ->count();

        return JsonResponse::create(['code' => 0, 'count' => $count, 'data' => $data]);
    }

    public function passOrder(Request $request)
    {
        $user = Auth::user();
        if (!$user->is_admin){
            return JsonResponse::create('无权访问');
        }
        $order = HazardousChemicalOrder::find($request->input('order_id'));
        $order->status = 'done';
        $order->save();
        return JsonResponse::create(['code'=>0, 'message'=>'操作成功']);
    }

    public function downloadOrder(Request $request)
    {
        $user = Auth::user();
        $order_id = $request->input('order_id', '');
        $order = HazardousChemicalOrder::find($order_id);
        if(!$order){
            return JsonResponse::create(['code' => 1, 'message' => '参数错误']);
        }
        if ($order->user_id !== $user->id && !$user->is_admin) {
            return JsonResponse::create(['code' => 1, 'message' => '无权限']);
        }
        $items = HazardousChemicalOrderItem::where('order_id',$order->id)
            ->get();
        $zip = "../storage/app/orderForm/危化品申购文件-业务号-".$order->id.".zip";
        if (file_exists($zip)){
            unlink($zip);
        }
        $zipFile = new \ZipArchive();
        $zipFile->open($zip,\ZipArchive::CREATE);
        Storage::disk('local')->makeDirectory('orderForm/order'.$order->id);
        foreach ($items as $item) {
            if ($item->hazardousTypeName === '精神麻醉类化学品') {
                $tmp = '../storage/app/docs/jingshen/华中科技大学管制类危险化学品购买申请表.docx';
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($tmp);
                $templateProcessor->setValue(
                    ['年', '月', '日',
                        '申购人姓名', '申购人电话',
                        '拟供货公司名称', '公司联系人姓名', '公司联系人电话',
                        '化学品名称','申购数量','危险特性','用途','存放地点',
                        '是否满足安全存放条件'],
                    [date("Y"), date("m"), date("d"),
                        $order->申购人姓名, $order->申购人手机号,
                        $item->拟供货公司名称,$item->公司联系人姓名,$item->公司联系人电话,
                        $item->中文名,$item->申购数量,$item->危险特性,$item->用途,$item->存放地点,
                        $item->是否满足安全存放条件]);
                $output = '../storage/app/orderForm/order'.$order->id."/".$item->中文名."-华中科技大学管制类危险化学品购买申请表.docx";
                $templateProcessor->saveAs($output);
                $zipFile->addFile($output,$item->中文名.'/华中科技大学管制类危险化学品购买申请表.docx');
            }elseif ($item->hazardousTypeName === '剧毒化学品'){
                $tmp = '../storage/app/docs/judu/华中科技大学管制类危险化学品购买申请表.docx';
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($tmp);
                $templateProcessor->setValue(
                    ['年', '月', '日',
                        '申购人姓名', '申购人电话',
                        '拟供货公司名称', '公司联系人姓名', '公司联系人电话',
                        '化学品名称','申购数量','危险特性','用途','存放地点',
                        '是否满足安全存放条件'],
                    [date("Y"), date("m"), date("d"),
                        $order->申购人姓名, $order->申购人手机号,
                        $item->拟供货公司名称,$item->公司联系人姓名,$item->公司联系人电话,
                        $item->中文名,$item->申购数量,$item->危险特性,$item->用途,$item->存放地点,
                        $item->是否满足安全存放条件]);
                $output = '../storage/app/orderForm/order'.$order->id."/".$item->中文名."-华中科技大学管制类危险化学品购买申请表.docx";
                $templateProcessor->saveAs($output);
                $zipFile->addFile($output,$item->中文名.'/华中科技大学管制类危险化学品购买申请表.docx');
                $zipFile->addFile('../storage/app/docs/judu/剧毒化学品购买凭证申请表.doc',$item->中文名.'/剧毒化学品购买凭证申请表.doc');
                $zipFile->addFile('../storage/app/docs/judu/华中科技大学剧毒及易制毒化学品使用安全承诺书.doc',$item->中文名.'/华中科技大学剧毒及易制毒化学品使用安全承诺书.doc');

            }elseif ($item->hazardousTypeName === '易制毒化学品'){
                $tmp = '../storage/app/docs/yizhidu/华中科技大学第二、三类易制毒化学品购买申请表.docx';
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($tmp);
                $templateProcessor->setValue(
                    ['年', '月', '日',
                        '申购人姓名', '申购人电话',
                        '拟供货公司名称', '公司联系人姓名', '公司联系人电话',
                        '化学品名称','申购数量','危险特性','用途','存放地点',
                        '是否满足安全存放条件'],
                    [date("Y"), date("m"), date("d"),
                        $order->申购人姓名, $order->申购人手机号,
                        $item->拟供货公司名称,$item->公司联系人姓名,$item->公司联系人电话,
                        $item->中文名,$item->申购数量,$item->危险特性,$item->用途,$item->存放地点,
                        $item->是否满足安全存放条件]);
                $output = '../storage/app/orderForm/order'.$order->id."/".$item->中文名."-华中科技大学管制类危险化学品购买申请表.docx";
                $templateProcessor->saveAs($output);
                $zipFile->addFile($output,$item->中文名.'/华中科技大学第二、三类易制毒化学品购买申请表.docx');
                $zipFile->addFile('../storage/app/docs/yizhidu/华中科技大学剧毒及易制毒化学品使用安全承诺书.doc',$item->中文名.'/华中科技大学剧毒及易制毒化学品使用安全承诺书.doc');
                $zipFile->addFile('../storage/app/docs/yizhidu/易制毒化学品合法使用证明.doc',$item->中文名.'/易制毒化学品合法使用证明.doc');

            }elseif ($item->hazardousTypeName === '易制爆化学品'){
                $tmp = '../storage/app/docs/yizhibao/华中科技大学管制类危险化学品购买申请表.docx';
                $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($tmp);
                $templateProcessor->setValue(
                    ['年', '月', '日',
                        '申购人姓名', '申购人电话',
                        '拟供货公司名称', '公司联系人姓名', '公司联系人电话',
                        '化学品名称','申购数量','危险特性','用途','存放地点',
                        '是否满足安全存放条件'],
                    [date("Y"), date("m"), date("d"),
                        $order->申购人姓名, $order->申购人手机号,
                        $item->拟供货公司名称,$item->公司联系人姓名,$item->公司联系人电话,
                        $item->中文名,$item->申购数量,$item->危险特性,$item->用途,$item->存放地点,
                        $item->是否满足安全存放条件]);
                $output = '../storage/app/orderForm/order'.$order->id."/".$item->中文名."-华中科技大学管制类危险化学品购买申请表.docx";
                $templateProcessor->saveAs($output);
                $zipFile->addFile($output,$item->中文名.'/华中科技大学管制类危险化学品购买申请表.docx');
                $zipFile->addFile('../storage/app/docs/yizhibao/华中科技大学易制爆化学品使用记录表.xlsx',$item->中文名.'/华中科技大学易制爆化学品使用记录表.xlsx');
                $zipFile->addFile('../storage/app/docs/yizhibao/华中科技大学易制爆化学品入库记录表.xlsx',$item->中文名.'/华中科技大学易制爆化学品入库记录表.xlsx');
                $zipFile->addFile('../storage/app/docs/yizhibao/华中科技大学易制爆化学品合法用途说明.docx',$item->中文名.'/华中科技大学易制爆化学品合法用途说明.docx');
                $zipFile->addFile('../storage/app/docs/yizhibao/华中科技大学易制爆化学品流向信息记录（备案）表.docx',$item->中文名.'/华中科技大学易制爆化学品流向信息记录（备案）表.docx');
            }
        }
        $zipFile->close();
        return response()->download($zip);
    }
}
