<?php

namespace App\Http\Controllers;

use App\CommonChemical;
use App\CommonDevice;
use App\HazardousChemicalOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpParser\Builder\Class_;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    //页面
    public function index()
    {
        $user = Auth::user();
        return view('home', ['user' => $user]);
    }

    public function commonChemical()
    {
        return view('commonChem');
    }

    public function hazardousChemical(Request $request)
    {
        return view('hazardousChem', ['search' => $request->input('search')]);
    }

    public function HazardousChemicalOrder()
    {
        return view('hazardousChemOrder');
    }

    public function commonDevice()
    {
        return view('commonDevice');
    }

    public function radioactiveElement()
    {
        return view('radioactiveElement');
    }

    //页面
    public function hazardousChemicalManage(Request $request)
    {
        $user = Auth::user();
        return view('chemicalManage', ['user' => $user, 'search' => $request->input('search')]);
    }

    public function hazardousChemicalOrderManage()
    {
        return view('hazardChemOrderManage');
    }

    public function commonChemicalManage()
    {
        return view('commonChemManage');
    }

    public function CommonDeviceManage()
    {
        return view('commonDeviceManage');
    }

    public function RadioactiveElementManage()
    {
        return view('radioactiveElementManage');
    }

    public function hazardousChemicalInOutManage()
    {
        return view('hazardousChemicalInOutManage');
    }

    public function userManage()
    {
        return view('userManage');
    }

    //===========================================================
    public function authorised()
    {
        if (Auth::check()) {
            return response('')->setStatusCode(200);
        } else {
            return response('')->setStatusCode(401);
        }
    }

    public function changePassword(Request $request)
    {
        $oldPassword = $request->input('oldPassword');
        $newPassword = $request->input('newPassword');
        $user = DB::table('users')
            ->where('id', Auth::user()->id)
            ->get()[0];
        if (!password_verify($oldPassword, $user->password)) {
            return view('home', ['user' => $user, 'changePassword' => 2]);
        }
        DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['password' => bcrypt($newPassword)]);
        return view('home', ['user' => $user, 'changePassword' => 1]);
    }

    public function uploadTable(Request $request)
    {
        $file = $request->file('file');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $sheet = $reader->load($file);
        $sheet->setActiveSheetIndex(0);

        $user = Auth::user();
        if ($request->input('type') === 'commonChem') {
            $worksheet = $sheet->getActiveSheet();
            // Get the highest row and column numbers referenced in the worksheet
            $highestRowIndex = $worksheet->getHighestRow(); // e.g. 10
//            return $highestRowIndex;
            $highestColumnIndex = 7;
            //跳过第一行
            for ($row = 2; $row <= $highestRowIndex; ++$row) {
                if(empty($worksheet->getCellByColumnAndRow(1, $row)->getValue()))
                    break;
                $attr = ['试剂名称' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                    '规格' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                    '数量' => floatval($worksheet->getCellByColumnAndRow(3, $row)->getValue()),
                    '单价' => floatval($worksheet->getCellByColumnAndRow(4, $row)->getValue()),
                    '总金额' => floatval($worksheet->getCellByColumnAndRow(5, $row)->getValue()),
                    '申购人姓名' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                    '申购人号码' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                    'user_id' => $user->id];
                $chem = new CommonChemical();
                $chem->setRawAttributes($attr);
                $chem->save();
            }
        } elseif ($request->input('type') === 'commonDevice') {
            $worksheet = $sheet->getActiveSheet();
            $highestRowIndex = $worksheet->getHighestRow();
            $highestColumnIndex = 7;
            //跳过第一行
            for ($row = 2; $row <= $highestRowIndex; ++$row) {
                if(empty($worksheet->getCellByColumnAndRow(1, $row)->getValue()))
                    break;

                $attr = [
                    '品名' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                    '规格' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                    '数量' => floatval($worksheet->getCellByColumnAndRow(3, $row)->getValue()),
                    '单价' => floatval($worksheet->getCellByColumnAndRow(4, $row)->getValue()),
                    '总金额' => floatval($worksheet->getCellByColumnAndRow(5, $row)->getValue()),
                    '采购负责人' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                    '负责人号码' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                    'user_id' => $user->id];
                $device = new CommonDevice();
                $device->setRawAttributes($attr);
                $device->save();
            }
        }
        return JsonResponse::create(['code' => 0, 'msg' => '0']);
    }


    public function test()
    {
        $user = Auth::user();
        return json_encode($user->getSafeCabinets());
    }

}