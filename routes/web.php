<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    return view('login');
    return redirect('/home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/changePassword', function (){
    return redirect('home');
});
Route::get('authorised','HomeController@authorised');

//普通试剂入库页面
Route::get('CommonChemical','HomeController@commonChemical');
//危化品申购页面
Route::get('HazardousChemical','HomeController@hazardousChemical');
Route::get('HazardousChemicalOrder','HomeController@HazardousChemicalOrder');
//低值设备入库页面
Route::get('commonDevice','HomeController@commonDevice');
//放射性元素申购页面
Route::get('RadioactiveElement','HomeController@radioactiveElement');


//危化品申报管理页面
Route::get('HazardousChemicalOrderManage','HomeController@hazardousChemicalOrderManage');
//普通试剂管理页面
Route::get('CommonChemicalManage','HomeController@commonChemicalManage');
//普通设备管理页面
Route::get('CommonDeviceManage','HomeController@CommonDeviceManage');
//放射元素管理页面
Route::get('RadioactiveElementManage','HomeController@RadioactiveElementManage');

Route::post('/changePassword', 'HomeController@changePassword');
Route::get('/hazardousChemicalManage','HomeController@hazardousChemicalManage');
Route::get('userManage','HomeController@userManage');

//普通试剂
Route::get('commonChemList','CommonChemicalController@getList');
Route::get('commonChemHistoryList','CommonChemicalController@getHistoryList');
Route::post('deleteCommonChem','CommonChemicalController@deleteChem');
Route::post('addCommonChem','CommonChemicalController@addChem');
Route::post('commonChemDetail','CommonChemicalController@getDetail');
Route::post('checkIfHazard','CommonChemicalController@checkIfHazard');
Route::get('downloadCommonChemForm','CommonChemicalController@downloadForm');
Route::post('batchDeleteCommonChem','CommonChemicalController@batchDelete');
Route::get('batchDownloadCommonChemForm','CommonChemicalController@batchDownload');

//普通设备
Route::get('commonDeviceList','CommonDeviceController@getList');
Route::post('deleteCommonDevice','CommonDeviceController@deleteDevice');
Route::post('addCommonDevice','CommonDeviceController@addDevice');
Route::post('commonDeviceDetail','CommonDeviceController@getDetail');
Route::get('downloadCommonDeviceForm','CommonDeviceController@downloadDeviceForm');
Route::get('batchDownloadCommonDeviceForm','CommonDeviceController@batchDownload');
Route::get('commonDeviceHistoryList','CommonDeviceController@getHistoryList');

//放射性元素
Route::post('addRadioactive','RadioactiveElementController@add');
Route::get('radioactiveList','RadioactiveElementController@getList');
Route::post('deleteRadioactive','RadioactiveElementController@delete');
Route::post('editRadioactive','RadioactiveElementController@edit');
Route::post('updateRadioactive','RadioactiveElementController@update');
Route::post('submitRadioactive','RadioactiveElementController@submit');
Route::post('radioactiveDetail','RadioactiveElementController@detail');
Route::get('downloadRadioactiveForm','RadioactiveElementController@downloadForm');

//用户管理
Route::get('userList','UserController@getList');
Route::post('addUser','UserController@addUser');
Route::post('editUser','UserController@editUserForm');
Route::post('updateUser','UserController@updateUser');
Route::post('deleteUser','UserController@deleteUser');

//危化品申购
Route::get('hazardChemCart','HazardousChemicalOrderController@getCart');
Route::post('addItemToHazardChemCart','HazardousChemicalOrderController@addItemToCart');
Route::post('deleteHazardChemCartItem','HazardousChemicalOrderController@deleteCartItem');
Route::get('editOrder','HazardousChemicalOrderController@editOrder');
Route::get('submitCart','HazardousChemicalOrderController@submitCart');
Route::get('getOrders','HazardousChemicalOrderController@getOrders');
Route::post('deleteOrder','HazardousChemicalOrderController@deleteOrder');
Route::post('storeOrder','HazardousChemicalOrderController@storeOrder');
Route::post('submitOrder','HazardousChemicalOrderController@submitOrder');
Route::get('viewOrderDetail','HazardousChemicalOrderController@orderDetail');
Route::get('downloadOrderForm','HazardousChemicalOrderController@downloadOrder');
//Route::post('DeleteHazardChemCartItem','HazardousChemicalOrderController@DeleteCartItem');

//危化品管理
Route::get('/hazardousChemicalList','HazardChemicalController@getList');
Route::post('addHazardChem','HazardChemicalController@addHazardChem');
Route::post('deleteHazardChem','HazardChemicalController@deleteHazardChem');
Route::post('editHazardChem','HazardChemicalController@editHazardChem');
Route::post('updateHazardChem','HazardChemicalController@updateHazardChem');

//危化品订单管理
Route::get("allHazardousChemicalOrders","HazardousChemicalOrderController@allOrders");
Route::post("passOrder",'HazardousChemicalOrderController@passOrder');

//普通试剂管理
Route::get('submittedCommonChemOrders','CommonChemicalController@submittedCommonChemOrders');
Route::post('approveChemBatch','CommonChemicalController@approveChemBatch');
Route::get('approvedCommonChemOrders','CommonChemicalController@approvedCommonChemOrders');


//普通设备管理
Route::get('submittedCommonDeviceOrders','CommonDeviceController@submittedCommonDeviceOrders');
Route::post('approveDeviceBatch','CommonDeviceController@approveDeviceBatch');
Route::get('approvedCommonDeviceOrders','CommonDeviceController@approvedCommonDeviceOrders');

//放射管理
Route::get('submittedRadioactive','RadioactiveElementController@submittedRadioactive');
Route::get('approvedRadioactive','RadioactiveElementController@approvedRadioactive');
Route::post('approveRadioactive','RadioactiveElementController@approveRadioactive');

Route::get('test','TestController@test');