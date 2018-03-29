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
        $user = Auth::user();
        if ($request->input('type') === 'commonChem') {
            $data = $sheet->getActiveSheet()->toArray();
            $data = array_reverse($data);
            array_pop($data);
            foreach ($data as $row) {
                $chem = new CommonChemical();
                $chem->setRawAttributes([
                    '试剂名称' => $row[0],
                    '规格' => $row[1],
                    '数量' => $row[2],
                    '单价' => $row[3],
                    '总金额' => $row[2] * $row[3],
                    '申购人姓名' => $row[5],
                    '申购人号码' => $row[6],
                    'user_id'=>$user->id
                ]);
                $chem->save();
            }
        }elseif ($request->input('type') === 'commonDevice'){
            $data = $sheet->getActiveSheet()->toArray();
            $data = array_reverse($data);
            array_pop($data);
            foreach ($data as $row) {
                $device = new CommonDevice();
                $device->setRawAttributes([
                    '品名' => $row[0],
                    '规格' => $row[1],
                    '数量' => $row[2],
                    '单价' => $row[3],
                    '总金额' => $row[2] * $row[3],
                    '采购负责人' => $row[5],
                    '负责人号码' => $row[6],
                    'user_id'=>$user->id
                ]);
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

Class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{

    private $startRow = 0;
    private $endRow = 0;
    private $columns = [];

    /**  Get the list of rows and columns to read  */
    public function __construct($startRow, $endRow, $columns)
    {
        $this->startRow = $startRow;
        $this->endRow = $endRow;
        $this->columns = $columns;
    }

    public function readCell($column, $row, $worksheetName = '')
    {
        //  Only read the rows and columns that were configured
        if ($row >= $this->startRow && $row <= $this->endRow) {
            if (in_array($column, $this->columns)) {
                return true;
            }
        }
        return false;
    }
}
