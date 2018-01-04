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
        $data = HazardousChemicalOrder::offset($size*($page-1))
            ->where('user_id',Auth::user()->id)
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = HazardousChemicalOrder::where('user_id',Auth::user()->id)
            ->count();
        foreach ($data as $d){
            if ($d['status'] === 'applying')
                $d['statusName'] = '正在申请中，请完善信息后提交';
            if ($d['status'] === 'submitted')
                $d['statusName'] = '已提交管理员审核，请注意报送纸质材料';
            if ($d['status'] === 'done')
                $d['statusName'] = '已完成';
        }

        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }

    public function getCart()
    {
        $data = HazardousChemicalCart::where('user_id',Auth::user()->id)
            ->get();
        return JsonResponse::create(['code'=>0,'count'=>count($data),'data'=>$data]);
    }

    public function addItemToCart(Request $request)
    {
        foreach ($request->input() as $chem)
        {
            $count = HazardousChemicalCart::where('chem_id',$chem['id'])
                ->where('user_id',Auth::user()->id)
                ->count();
            if ($count === 0){
                $item = new HazardousChemicalCart();
                $item->setRawAttributes([
                    '中文名'=>$chem['中文名'],
                    'CAS'=>$chem['CAS'],
                    'hazardous_type'=>$chem['hazardous_type'],
                    'chem_id'=>$chem['id'],
                    '别名'=>$chem['别名'],
                    'hazardousTypeName'=>$chem['hazardousTypeName'],
                    'user_id'=>Auth::user()->id
                ]);
                $item->save();
            }
        }
        return JsonResponse::create(['code'=>0,'message'=>'添加成功']);
    }

    public function deleteCartItem(Request $request)
    {
        $user = Auth::user();
        $item = HazardousChemicalCart::find($request->input('id'));
        if ($item->user_id != $user->id && !$user->is_admin){
            return JsonResponse::create(['code'=>1,'message'=>'无权限删除']);
        }
        if ($item->delete())
        {
            return JsonResponse::create(['code'=>0,'message'=>'删除成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'删除失败']);
        }

    }

    public function editOrder(Request $request)
    {
        $user = Auth::user();
        $items = HazardousChemicalCart::where('user_id',$user->id)
            ->get();
        if (count($items) === 0){
            return JsonResponse::create([]);
        }

        return view('chemical.hazardChemOrderForm',['items'=>$items]);
    }

    public function submitCart(Request $request)
    {
        $user = Auth::user();
        $items = HazardousChemicalCart::where('user_id',$user->id)
            ->get();
        if (count($items) === 0){
            return redirect('HazardousChemicalOrder');
        }
        $order = new HazardousChemicalOrder();
        $order->setRawAttributes([
            'user_id'=>$user->id,
            'status'=>'applying'
        ]);
        $order->save();
        //cart item to order item
        foreach ($items as $item){
            $order_item = new HazardousChemicalOrderItem();
            $order_item->setRawAttributes([
                'order_id'=>$order->id,
                '中文名'=>$item['中文名'],
                'CAS'=>$item['CAS'],
                'hazardous_type'=>$item['hazardous_type'],
                '别名'=>$item['别名'],
                'chem_id'=>$item['chem_id'],
                'hazardousTypeName'=>$item['hazardousTypeName']
            ]);
            $order_item->save();
            $item->delete();
        }
    }
}
