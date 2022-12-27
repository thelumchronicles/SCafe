<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController as login;
use App\Http\Controllers\EmployeeController as employee;
use App\Http\Controllers\AdminController as admin;
use App\Http\Controllers\NhaBepController as nhabep;
use App\Http\Controllers\ApiController as api;
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


Route::get('testRouteAndroid', function () {
    $sessionVarJSON = array(
        "sessionValue" => session()->get("TestKey")
    );
    echo json_encode($sessionVarJSON);
});




Route::get('forgetSession', function () {
    session()->forget("TestKey");
});

Route::get('testSetSession', function () {
    session()->put("TestKey" , "UserLoggedIn");
});



Route::prefix('/api')->group(function () {
    Route::get("csrfToken" , function(){
        return csrf_token();
    });
    Route::post('login' , [api::class , 'postLogin']);
    Route::get('getSessionLogin' , [api::class , 'getSessionLogin']);
    Route::get('getLoggedDetail' , [api::class , 'getLoggedDetail']);
    Route::post('changePassword', [api::class , 'changePassword']);
    Route::get('getRooms', [api::class , 'getRooms']);
    Route::get('getTables', [api::class , 'getTables']);
    Route::get('getTablesWithRoomID/{room_id}' , [api::class , 'getTablesWithRoomID']);
    Route::get('getTablesCustoms/{status}' , [api::class , 'getTablesWithStatus']);
    Route::get('getTablesCustoms/{room_id}/{status}' , [api::class , 'getTablesWithStatusAndRoomID']);
    Route::get('getProductCategories' , [api::class , 'getProductCategories']);
    Route::get('getAllProducts/{category_id}', [api::class , 'getAllProducts']);
    Route::get('getTableDetail/{id}' , [api::class , 'getTableDetail']);
    Route::get('getProductsInTable/{id}' , [api::class , 'getProductsInTable']);
    Route::get('increaseAmount/{id}/{invoice_id}' , [api::class , 'themSoLuong']);
    Route::get('decreaseAmount/{id}/{invoice_id}' , [api::class , 'giamSoLuong']); 
    Route::get('deleteProduct/{id}/{invoice_id}', [api::class , 'deleteProduct']);
    Route::get('getDiscounts/{invoice_id}' , [api::class , 'getDiscounts']);
    Route::get('setDiscount/{discount_id}/{invoice_id}' , [api::class , 'setDiscount']);
    Route::get('resetDiscount/{invoice_id}' , [api::class , 'resetDiscount']);    
    Route::get('prepareTable/{table_id}', [api::class , 'prepareTable']);
    Route::get('themThucDon/{invoice_id}/{product_id}/{amount}' , [api::class , 'themThucDon']);
    Route::get('huyThucDon/{invoice_id}' , [api::class , 'huyThucDon']);
    Route::get('getSeparateTable/{table_id}' , [api::class , 'getSeparateTable']);
    Route::get('thanhToan/{invoice_id}' , [api::class , 'thanhToan']);
});


Route::get('/', function () {
    return redirect()->route('getLogin');
})->name("mainIndex")->middleware("login-middleware");

// User Auth Routes
Route::post('login' , [login::class , 'postLogin'])->name("postLogin");
Route::get('login', [login::class , 'getLogin'])->name("getLogin")->middleware("login-middleware");;
Route::get('logout', [login::class , 'logout'])->name("logout");

Route::prefix('admin')->middleware('admin-middleware')->group(function () {
    Route::get('/' , [admin::class , 'index'])->name("adminIndex");
    Route::prefix('danhmucmonan')->group(function () {
        Route::get('/', [admin::class , 'getFoodCategory'])->name("foodCategory");
        Route::post('/them' , [admin::class , 'postAddFoodCategory'])->name("postAddFoodCategory");
        Route::post('/xoa' , [admin::class , 'postDeleteFoodCategory'])->name("postDeleteFoodCategory");
        Route::post('/sua' , [admin::class , 'postEditFoodCategory'])->name("postEditFoodCategory");
        Route::prefix('detail')->group(function () {
            Route::get('/{id}', [admin::class , 'detailCategory'])->name("detailCategory");
            Route::post('/them', [admin::class , 'addProduct'])->name("addProduct");
            Route::post('/sua' , [admin::class , 'editProduct'])->name("editProduct");
            Route::post('/xoa' , [admin::class , 'deleteProduct'])->name("deleteProduct");
        });

    });

    Route::prefix('phongban')->group(function () {
        Route::get('/' , [admin::class , 'getRoom'])->name("roomIndex");
        Route::post('/them', [admin::class , 'addRoom'])->name("addRoom");
        Route::post('/xoa', [admin::class , 'deleteRoom'])->name("deleteRoom");
        Route::post('/sua' , [admin::class , 'editRoom'])->name("editRoom");
        Route::prefix('detail')->group(function () {
            Route::get('/{id}', [admin::class , 'detailRoom'])->name("detailRoom");
            Route::post('/them', [admin::class , 'addTable'])->name("addTable");
            Route::post('/sua' , [admin::class , 'editTable'])->name("editTable");
            Route::post('/xoa' , [admin::class , 'deleteTable'])->name("deleteTable");
        });
    });

    Route::prefix('quanly')->group(function () {
        Route::get('/', [admin::class , 'manageAccount'])->name("manageAccount");
        Route::post('/them', [admin::class , 'addAccount'])->name("addAccount");
        Route::post('/sua', [admin::class , 'editAccount'])->name("editAccount");
        Route::post('/xoa' , [admin::class , 'deleteAccount'])->name("deleteAccount");
    });  

    Route::get('/chiendich', [admin::class , 'getChienDich'])->name("chienDich");
    Route::post('/themChienDich', [admin::class , 'themChienDich'])->name("themChienDich");
    Route::get('/xoaChienDich/{id}' , [admin::class , 'xoaChienDich'])->name("xoaChienDich");

});

Route::prefix('employee')->middleware('employee-middleware')->group(function () {
    Route::get('/' , [employee::class , 'getPhongBan'])->name("employeeIndex");
    Route::get('/filter/{type}' , [employee::class , 'getPhongBanWithOptions'])->name("employeeIndexWithOptions");
    Route::get('/phongban/filter/{id}' , [employee::class , 'getRoomDetail'])->name("getRoomDetail");
    Route::get('phongban/{id}/filter/{type}', [employee::class , 'getRoomDetailWithOptions'])->name("getRoomDetailWithOptions");
    Route::get('/setban/{id}' , [employee::class , 'setTable'])->name("setTable");
    Route::prefix('thucdon')->group(function () {
        Route::get('/' , [employee::class , 'getThucDon'])->name("thucdon");
        Route::get('/{id}' , [employee::class , 'getDetailCategory'])->name("getDetailCategory");
        Route::post('/searchCategoryAjax' , [employee::class , 'searchCategoryAjax'])->name("searchCategoryAjax");  
        Route::get('/huythucdon/{id}' , [employee::class , 'huyThucDon'])->name("huyThucDon");
        Route::get('/themthucdon/{id}', [employee::class , 'themThucDon'])->name("themThucDon");
        Route::get('/themSoLuong/{id}' , [employee::class , 'themSoLuong'])->name("themSoLuong");
        Route::get('/giamSoLuong/{id}' , [employee::class , 'giamSoLuong'])->name("giamSoLuong");
        Route::get('/deleteInvoiceProduct/{id}', [employee::class , 'deleteInvoiceProduct'])->name("deleteInvoiceProduct");
        Route::get('/updateDiscount/{id}' , [employee::class , 'updateDiscount'])->name("updateDiscount");
        
        
    });
    Route::get('/thanhToan' , [employee::class , 'thanhToan'])->name("thanhToan");
    Route::post('/chuyenBanAjax' , [employee::class , 'chuyenBanAjax'])->name("chuyenBanAjax");
    Route::get('/chuyenBan/{id}' , [employee::class , 'chuyenBan'])->name("chuyenBan");
    Route::post('/timKiem' , [employee::class , 'timKiem'])->name("timKiem");
    Route::post('changePassword', [employee::class , 'changePassword'])->name('changePassword');
});

Route::get('error', function () {
    return "Bạn không có quyền truy cập vào trang này";
})->name("errorPage");

Route::get('error2', function () {
    return "Có lỗi xảy ra!";
})->name("errorPage2");


