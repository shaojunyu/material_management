<?php

namespace App\Http\Controllers;

use App\User;
use Egulias\EmailValidator\Exception\AtextAfterCFWS;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getList(Request $request)
    {
        $page = $request->input('page');
        $size = $request->input('limit');
        $data = User::offset($size*($page-1))
            ->take($size)
            ->orderBy('id', 'desc')
            ->get();
        $count = User::count();
        return JsonResponse::create(['code'=>0,'count'=>$count,'data'=>$data]);
    }

    public function addUser(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $user = new User();
        $user->setRawAttributes([
            'name'=>$request->input('name'),
            'password'=>bcrypt($request->input('password')),
            'staff_id'=>$request->input('staff_id')
        ]);
        if ($user->save()){
            return JsonResponse::create(['code'=>0,'message'=>'添加成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'添加失败，请重试']);
        }


    }

    public function editUserForm(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $user = User::find($request->input('id'));
        return view('user.userInfo',['user'=>$user]);
    }

    public function updateUser(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $user = User::find($request->input('id'));
        $user->setRawAttributes([
            'name'=>$request->input('name'),
            'staff_id'=>$request->input('staff_id')
        ]);
        if ($request->input('password')){
            $user->setAttribute('password',bcrypt($request->input('password')));
        }

        if ($user->update()){
            return JsonResponse::create(['code'=>0,'message'=>'更新成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'更新失败，请重试']);
        }

    }

    public function deleteUser(Request $request)
    {
        if (Auth::user()->is_admin !== 1){
            return JsonResponse::create(['code'=>1,'message'=>'unauthorized request!']);
        }
        $user = User::find($request->input('id'));
        if ($user->delete()){
            return JsonResponse::create(['code'=>0,'message'=>'删除成功']);
        }else{
            return JsonResponse::create(['code'=>1,'message'=>'删除失败，请重试']);
        }
    }
}
