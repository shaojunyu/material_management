<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\HazardousChemicalOrderItem;
use App\HazardousChemicalOrder;
use App\HazardousChemicalCart;
use Illuminate\Support\Facades\Auth;

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
            return redirect('HazardousChemicalOrder');
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
        return JsonResponse::create(['code' => 0, 'message' => '提交成功']);
    }
}
