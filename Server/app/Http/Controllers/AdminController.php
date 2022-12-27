<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AdminController extends Controller
{
    public function index(){
        $totalRevenue = DB::table('invoice')->where("status" , 1)->sum("final_price");
        $inOrderTable = DB::table('atable')->where("status" , 1)->count();
        $haventFinishedIncome = DB::table('invoice')->where("status" , 0)->sum('final_price');
    
        return view('admin/index' , compact('inOrderTable' , 'haventFinishedIncome' , 'totalRevenue'));
    }

    public function getFoodCategory(){
        $product_category = DB::table('product_category')->get();
        return view('admin/products/index' , compact('product_category'));
    }

    public function getRoom(){
        $rooms = DB::table('room')->get();
        return view('admin/rooms/index' , compact('rooms'));
    }

    public function addRoom(Request $res){
        if (empty($res->newRoomName)){
            echo "Bạn phải nhập đầy đủ các trường";
        }
        else {
            $room = DB::table('room')->where('room_name' , $res->newRoomName)->first();
            if ($room === null) {
                DB::table('room')->insert(['room_name' => $res->newRoomName]);
                echo "Success";
            }
            else {
                echo "Phòng bàn đã tồn tại";
            }
        }

    }

    public function deleteRoom(Request $res){
        DB::table('room')->where("room_id" , $res->roomID)->delete();
        echo "Success";
    }

    public function editRoom(Request $res){
        if (empty($res->editedRoomName)){
            echo "Bạn phải nhập đầy đủ các trường";
        }
        else {
            $room = DB::table('room')->where('room_name' , $res->editedRoomName)->first();
            if ($room === null) {
                DB::table('room')->where("room_id" , $res->roomID)->update(['room_name' => $res->editedRoomName]);
                echo "Success";
            }
            else {
                echo "Phòng bàn đã tồn tại";
            }
        }

    }

    public function postAddFoodCategory(Request $res){
        if (empty($res->categoryName)) {
            echo "Bạn chưa nhập tên danh mục";
        }
        else {
            $category = DB::table('product_category')->where("category_name" , $res->categoryName)->first();
            if ($category == null) {
                DB::table('product_category')->insert(['category_name' => $res->categoryName]);
                echo "Success";

            }
            else {
                echo "Danh mục đã tồn tại";
            }
        } 
       
    }

    public function postDeleteFoodCategory(Request $res){
        DB::table('product_category')->where("category_id" , $res->id)->delete();
        echo "Success";
    }

    public function postEditFoodCategory(Request $res){
        if (empty($res->categoryName)){
            echo "Bạn chưa nhập tên danh mục";
        }
        else {
            $category = DB::table('product_category')->where("category_name" , $res->categoryName)->first();
            if ($category === null){
                DB::table('product_category')->where("category_id" , $res->categoryID)->update(['category_name' => $res->categoryName]);
                echo "Success";
            }
            else {
                echo "Tên danh mục đã tồn tại";
            }
        }

    }

    public function detailCategory($id){
        $category = DB::table('product_category')->where("category_id" , $id)->first();
        if ($category == null) {
            return redirect()->route("errorPage2");
        }
        else {
            $products = DB::table('product')->where("category_id" , $id)->get();
            return view("admin/products/detail_category" , compact('products' , 'id' , 'category'));
        }
   
    }

    public function uploadImageFunc(Request $res , $savePath){
        $imageName = "";
        if ($res->hasFile('imgInp')) {
            $res->validate([
                'imgInp' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
            $imageName = $savePath . time().'.'.$res->imgInp->getClientOriginalExtension();
            $res->imgInp->move(public_path().$savePath,$imageName);
        }
        return $imageName;
    }

    public function addProduct(Request $res){
     
        if (empty($res->newProductPrice) || empty($res->newProductName)){
            echo "Bạn phải nhập đủ trường";
        }
        else {
            $product = DB::table('product')->where("product_name" , $res->newProductName)->first();
            if ($product === null){
                $imageName = $this->uploadImageFunc($res,'/images/product/');
                DB::table('product')->insert(['product_image' => $imageName,'product_name' => $res->newProductName , 'product_price' => $res->newProductPrice , 'category_id' => $res->currentCategoryID]);
                echo "Success";
            }
            else {
                echo "Mặt hàng đã tồn tại";
            }
        }
    }

    public function editProduct(Request $res){
        if (empty($res->editedProductName) || empty($res->editedProductPrice)) {
            echo "Bạn phải nhập đủ trường";
        }
        else {
            $current_product = DB::table('product')->where('product_id' , $res->productID)->first();
            if ($current_product->product_name == $res->editedProductName) {
                $imageName = $this->uploadImageFunc($res,'/images/product/');
                if ($res->hasFile('imgInp')){
                    DB::table('product')->where('product_id' , $res->productID)->update([ 'product_image' => $imageName , 'product_name' => $res->editedProductName , 'product_price' => $res->editedProductPrice]);
                }
                else {
                    DB::table('product')->where('product_id' , $res->productID)->update([ 'product_name' => $res->editedProductName , 'product_price' => $res->editedProductPrice]);
                }
              
                echo "Success";
            }
            else {
                $product = DB::table('product')->where('product_name' , $res->editedProductName)->first();
                if ($product === null){
                    $imageName = $this->uploadImageFunc($res,'/images/product/');
                    if ($res->hasFile('imgInp')){
                        DB::table('product')->where('product_id' , $res->productID)->update([ 'product_image' => $imageName , 'product_name' => $res->editedProductName , 'product_price' => $res->editedProductPrice]);
                    }
                    else {
                        DB::table('product')->where('product_id' , $res->productID)->update([ 'product_name' => $res->editedProductName , 'product_price' => $res->editedProductPrice]);
                    }
                    echo "Success";
                }
                else {
                    echo "Mặt hàng đã tồn tại";
                }
            }
        }
    }

    public function deleteProduct(Request $res){
        DB::table('product')->where('product_id' , $res->productID)->delete();
        echo "Success";
    }

    public function detailRoom($id){
        $room = DB::table('room')->where('room_id' , $id)->first();
        if ($room == null) {
            return redirect()->route("errorPage2");
        }
        else {
            $atables = DB::table('atable')->where('room_id' , $id)->get();
            return view('admin/rooms/detail' , compact('atables' , 'room'));
        }
        
    }


    public function addTable(Request $res){
        if (empty($res->newTableName)){
            echo "Bạn phải nhập đủ trường";
        }
        else {
            $product = DB::table('atable')->where("atable_name" , $res->newTableName)->first();
            if ($product === null){
                DB::table('atable')->insert(['room_id' => $res->roomID , 'atable_name' => $res->newTableName , 'status' => 0]);
                echo "Success";
            }
            else {
                echo "Tên bàn bị trùng";
            }
        }
    }

    public function deleteTable(Request $res){
        DB::table('atable')->where("atable_id" , $res->tableID)->delete();
        echo "Success";
    }

    public function editTable(Request $res){
        if (empty($res->editedTableName)){
            echo "Bạn phải nhập đủ trường";
        }
        else {
            $atable = DB::table('atable')->where("atable_name" , $res->editedTableName)->first();
            if ($atable === null) {
                DB::table('atable')->where("atable_id" , $res->tableID )->update(['atable_name' => $res->editedTableName]);
                echo "Success";
            }
            else {
                echo "Tên bàn bị trùng";
            }
        }        
    }

    public function manageAccount(){
        $loggedUser = DB::table('user')->where("user_id" , session()->get('user_id'))->first();
        $users = DB::table('user')->get();
        return view("admin/manage/index" , compact("users" , "loggedUser"));
    }

    public function addAccount(Request $res){

        if (strlen(trim($res->newUserFullName)) <=0 || strlen(trim($res->newUserName)) <=0 || strlen(trim($res->newUserPassword)) <=0 || strlen(trim($res->newUserPermission)) <=0 || strlen(trim($res->newUserGender)) <=0){
            echo "Bạn phải nhập đủ trường!";
        }
        else {
            $user = DB::table('user')->where("user_name" , $res->newUserName)->first();
            if ($user === null) {
                $imageName = $this->uploadImageFunc($res,'/images/account/');
                DB::table('user')->insert(['user_fullname' => $res->newUserFullName , 'user_name' => $res->newUserName , 'user_password' => $res->newUserPassword , 'user_image' => $imageName , 'user_gender' => $res->newUserGender , 'user_permission' => $res->newUserPermission]);
                echo "Success";
            }
            else {
                echo "Tên đăng nhập bị trùng, vui lòng chọn tên khác!";
            }
        }   
        
    }

    public function editAccount(Request $res) {
        
        if (strlen(trim($res->editedUserFullName)) <=0 || strlen(trim($res->editedUserName)) <=0 ||  strlen(trim($res->editedUserPermission)) <=0 || strlen(trim($res->editedUserGender)) <=0 || strlen(trim($res->editedUserID)) <=0){
            echo "Bạn phải nhập đủ trường!";
        }
        else {

            if ($res->editedUserID == session()->get("user_id")){
      
                if (strlen(trim($res->originalUserPassword)) <= 0) {
                    echo "Bạn chưa nhập mật khẩu hiện tại hoặc mật khẩu mới!!!";
                }
                else {
                    $queryUser = DB::table('user')->where("user_id" , $res->editedUserID)->first();
           
                    if ($queryUser->user_password == $res->originalUserPassword) {
                        $imageName = $this->uploadImageFunc($res,'/images/account/');
                        $editUser = DB::table('user')->where("user_id" , $res->editedUserID)->first();
                        if ($editUser->user_name == $res->editedUserName){
                            if($res->editedUserPassword == $res->editedUserPasswordConfrim){
                                if (!empty($imageName)) {
                                    DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_image' => $imageName]);
                                }
                                if (!empty($res->editedUserPassword)){
                                    DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_password' => $res->editedUserPassword]);
                                }
                         
                                DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_fullname' => $res->editedUserFullName , 'user_name' => $res->editedUserName , 'user_gender' => $res->editedUserGender , 'user_permission' => $res->editedUserPermission]);
                                echo "Success";
                            }
                            else {
                                echo "Mật khẩu mới không trùng khớp!!!";
                            }

                        }
                        else {
                            $user = DB::table('user')->where("user_name" , $res->editedUserName)->first();
                            if ($user === null) {
                                $imageName = $this->uploadImageFunc($res,'/images/account/');
                                if (!empty($imageName)) {
                                    DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_image' => $res->editedUserImage]);
                                }
                                if (!empty($res->editedUserPassword)){
                                    DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_password' => $res->editedUserPassword]);
                                }
                                DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_fullname' => $res->editedUserFullName , 'user_name' => $res->editedUserName , 'user_gender' => $res->editedUserGender , 'user_permission' => $res->editedUserPermission]);
                                echo "Success";
                            }
                            else {
                                echo "Tên đăng nhập bị trùng, vui lòng chọn tên khác!";
                            }
                        }
                    }
                    else {
                        echo "Mật khẩu hiện tại không đúng! , vui lòng thử lại!!!";
                    }
                
                }
            }
            else {
                $imageName = $this->uploadImageFunc($res,'/images/account/');
                $editUser = DB::table('user')->where("user_id" , $res->editedUserID)->first();
                if ($editUser->user_name == $res->editedUserName){
                    if (!empty($imageName)) {
                        DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_image' => $imageName]);
                    }
                    if (!empty($res->editedUserPassword)){
                        DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_password' => $res->editedUserPassword]);
                    }
                    DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_fullname' => $res->editedUserFullName , 'user_name' => $res->editedUserName , 'user_gender' => $res->editedUserGender , 'user_permission' => $res->editedUserPermission]);
                    echo "Success";
                }
                else {
                    $user = DB::table('user')->where("user_name" , $res->editedUserName)->first();
                    if ($user === null) {
                        $imageName = $this->uploadImageFunc($res,'/images/account/');
                        if (!empty($imageName)) {
                            DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_image' => $res->editedUserImage]);
                        }
                        if (!empty($res->editedUserPassword)){
                            DB::table('user')->where('user_id' , $res->editedUserID)->update(['user_password' => $res->editedUserPassword]);
                        }
                        DB::table('user')->update(['user_fullname' => $res->editedUserFullName , 'user_name' => $res->editedUserName , 'user_gender' => $res->editedUserGender , 'user_permission' => $res->editedUserPermission]);
                        echo "Success";
                    }
                    else {
                        echo "Tên đăng nhập bị trùng, vui lòng chọn tên khác!";
                    }
                }
            }
 
            
   
        }   
        
    }

    public function deleteAccount(Request $res) {
        $user = DB::table('user')->where('user_id' , $res->userID)->first(); 
        if ($user->user_permission == 0){
            $admin = DB::table('user')->where('user_permission' , 0)->get();
            if ($admin->count() > 1){
                DB::table('user')->where('user_id' , $res->userID)->delete();
                echo "Success";
            }
            else {
                echo "Cần tối thiểu một acc admin để quản trị";
            }
        }
        else {
            DB::table('user')->where('user_id' , $res->userID)->delete();
            echo "Success";
        }
        
        
    }

    public function getChienDich(){
        $discounts = DB::table('discount')->get();
        return view('admin/chiendich/index' , compact("discounts"));
    }

    public function themChienDich(Request $res){
        if (strlen(trim($res->discountDes)) <= 0 || strlen(trim($res->discountCode)) <= 0 || strlen(trim($res->discountPercent)) <= 0) {
            echo "Bạn phải nhập đủ trường!";
        }
        else {
            if ($res->discountPercent > 100 || $res->discountPercent < 1 ) {
                echo "Lỗi giảm giá";
            }
            else {
                $discount = DB::table('discount')->where("discount_code" , $res->discountCode)->first();
                if ($discount == null) {
                    DB::table('discount')->insert(['discount_des' => $res->discountDes , 'discount_code' => $res->discountCode , 'discount_percent' => $res->discountPercent]);
                    echo "Success";
                }
                else {
                    echo "Chiến dịch đã tồn tại";
                }
            }

        }

    }

    public function xoaChienDich($id){
        DB::table('discount')->where("discount_id" , $id)->delete();
        return redirect()->back();
    }

}
