<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class ApiController extends Controller
{
    public function postLogin(Request $res){
        $user = DB::table('user')->where("user_name" , $res->username)->where("user_password" , $res->password)->first();
        if ($user == null) {
            echo "Sai tên đăng nhập hoặc mật khẩu!!!";
        }
        else {
            Session::put('user_id' , $user->user_id);
            Session::put('user_name', $user->user_name);
            Session::put('user_fullname' , $user->user_fullname);
            if ($user->user_gender == 0) {
                Session::put('user_gender', "Nam");
            }
            else {
                Session::put('user_gender', "Nữ");
            }

            Session::put('user_image' , $user->user_image);
            Session::put('user_permission', $user->user_permission);
            Session::put('logged', 1);
            echo "Success";
        }    
    }

    public function getLoggedDetail(){
        $object = array(
            "user_id" => session()->get("user_id"),
            "user_name" => session()->get("user_name"),
            "user_fullname" => session()->get("user_fullname"),
            "user_gender" => session()->get("user_gender"),
            "user_image" => session()->get("user_image"),
            "user_permission" => session()->get("user_permission"),
            "logged" => session()->get("logged"),
        );
        echo json_encode($object, JSON_UNESCAPED_UNICODE);
    }

    public function changePassword(Request $res){
        $user = DB::table('user')->where("user_id" , session()->get("user_id"))->first();
       
        if (strlen(trim($res->oldPassword)) <=0 || strlen(trim($res->newPassword)) <= 0) {
            echo "Bạn phải nhập đủ trường";
        }
        else {
           
            if ($res->oldPassword == $user->user_password){
                DB::table('user')->where("user_id" , session()->get("user_id"))->update(['user_password' => $res->newPassword]);
                echo "Success";
     
            }
            else {
                echo "Mật khẩu cũ không đúng";
            }
        }

    }

    public function getRooms(){
        $rooms = DB::table('room')->get();
        echo json_encode($rooms, JSON_UNESCAPED_UNICODE);
    }

    public function getTables(){
        $atables = DB::table('atable')->get();
        $atableMods = array();
        foreach($atables as $atable) {
            $invoice = DB::table('invoice')->where("invoice_id" ,$atable->invoice_id )->first();
            $finalPrice = 0;
            if ($invoice != null) {
                $finalPrice = $invoice->final_price;
            };
            $atablesMod = array(
                "atable_id" => $atable->atable_id,
                "atable_name" => $atable->atable_name,
                "invoice_id" => $atable->invoice_id,
                "final_price" => $finalPrice,
                "status" => $atable->status
            );
            array_push($atableMods, $atablesMod);
        }

     

        echo json_encode($atableMods, JSON_UNESCAPED_UNICODE);
    }

    public function getTablesWithRoomID($room_id){

        $atables = DB::table('atable')->where("room_id" , $room_id)->get();
        $atableMods = array();
        foreach($atables as $atable) {
            $invoice = DB::table('invoice')->where("invoice_id" ,$atable->invoice_id)->first();
            $finalPrice = 0;
            if ($invoice != null) {
                $finalPrice = $invoice->final_price;
            };
            $atablesMod = array(
                "atable_id" => $atable->atable_id,
                "atable_name" => $atable->atable_name,
                "invoice_id" => $atable->invoice_id,
                "final_price" => $finalPrice,
                "status" => $atable->status
            );
            array_push($atableMods, $atablesMod);
        }

     

        echo json_encode($atableMods, JSON_UNESCAPED_UNICODE);
    }

    public function getTablesWithStatus($status){
            
        $atables = DB::table('atable')->where("status" , $status)->get();
        $atableMods = array();
        foreach($atables as $atable) {
            $invoice = DB::table('invoice')->where("invoice_id" ,$atable->invoice_id)->first();
            $finalPrice = 0;
            if ($invoice != null) {
                $finalPrice = $invoice->final_price;
            };
            $atablesMod = array(
                "atable_id" => $atable->atable_id,
                "atable_name" => $atable->atable_name,
                "invoice_id" => $atable->invoice_id,
                "final_price" => $finalPrice,
                "status" => $atable->status
            );
            array_push($atableMods, $atablesMod);
        }

     

        echo json_encode($atableMods, JSON_UNESCAPED_UNICODE);
    }

    public function getTablesWithStatusAndRoomID($room_id,$status){
        $atables = DB::table('atable')->where("room_id" , $room_id)->where("status" , $status)->get();
        $atableMods = array();
        foreach($atables as $atable) {
            $invoice = DB::table('invoice')->where("invoice_id" ,$atable->invoice_id)->first();
            $finalPrice = 0;
            if ($invoice != null) {
                $finalPrice = $invoice->final_price;
            };
            $atablesMod = array(
                "atable_id" => $atable->atable_id,
                "atable_name" => $atable->atable_name,
                "invoice_id" => $atable->invoice_id,
                "final_price" => $finalPrice,
                "status" => $atable->status
            );
            array_push($atableMods, $atablesMod);
        }

     

        echo json_encode($atableMods, JSON_UNESCAPED_UNICODE);
    }

    public function getProductCategories(){
        $product_categories = DB::table('product_category')->get();
        echo json_encode($product_categories, JSON_UNESCAPED_UNICODE);
    }

    public function getAllProducts($category_id){
        if ($category_id == -1) {
            $products = DB::table('product')->get();
        }
        else {
            $products = DB::table('product')->where("category_id",$category_id)->get();
        }

        echo json_encode($products , JSON_UNESCAPED_UNICODE);
    }

    public function getTableDetail($table_id) {
        $currentTable = DB::table('atable')->where("atable_id" , $table_id)->first();
        $currentInvoice = DB::table('invoice')->where("invoice_id" , $currentTable->invoice_id)->first();
        Session::put('system_current_invoice_id' , $currentTable->invoice_id);
        echo json_encode($currentInvoice , JSON_UNESCAPED_UNICODE);
    }

    public function getProductsInTable($table_id) {
        $currentTable = DB::table('atable')->where("atable_id" , $table_id)->first();
        $invoiceSeps = DB::table('invoice_sep')->where("invoice_id" , $currentTable->invoice_id)->get();
        $productsInTable = array();
        foreach ($invoiceSeps as $invoice) {
            $product = DB::table('product')->where("product_id" , $invoice->product_id)->first();
            $productPush = array(
                "product_id" => $invoice->product_id,
                "product_name" => $product->product_name,
                "quantity" => $invoice->quantity,
                "product_price" => $invoice->product_price,
                "total_price" => $invoice->total_price
            );
            array_push($productsInTable,$productPush);

        }
        echo json_encode($productsInTable , JSON_UNESCAPED_UNICODE);
    }

    public function themSoLuong($id,$invoice_id){
        $currentInvoiceSep = DB::table('invoice_sep')->where("invoice_id" , $invoice_id)->where("product_id" , $id)->first();  
        DB::table('invoice_sep')->where("invoice_id" , $invoice_id)->where("product_id" , $id)->update(["quantity" => $currentInvoiceSep->quantity + 1 , "total_price" => ($currentInvoiceSep->product_price * ($currentInvoiceSep->quantity + 1) )]);
        $this->updateInvoice($invoice_id);
        echo "Success";
    }

    
    public function giamSoLuong($id,$invoice_id){
        $currentInvoiceSep = DB::table('invoice_sep')->where("invoice_id" , $invoice_id)->where("product_id" , $id)->first();  
        if ($currentInvoiceSep->quantity > 1){
            DB::table('invoice_sep')->where("invoice_id" , $invoice_id)->where("product_id" , $id)->update(["quantity" => $currentInvoiceSep->quantity - 1 , "total_price" => ($currentInvoiceSep->product_price * ($currentInvoiceSep->quantity - 1) )]);
            $this->updateInvoice($invoice_id);
        }
        echo "Success";
    }



    public function updateInvoice($invoice_id){
        $selectedInvoice = DB::table('invoice')->where("invoice_id" , $invoice_id)->first();
        $total_price = 0;
        $final_price = 0;
        $discount_price = 0;
        $invoiceseps = DB::table('invoice_sep')->where("invoice_id" , $invoice_id)->get();
        foreach ($invoiceseps as $invoice) {
            $total_price += $invoice->quantity * $invoice->product_price;
        }
        
        if ($selectedInvoice->discount_percent != null){
            $final_price = $total_price - ($total_price * $selectedInvoice->discount_percent) / 100;
            $discount_price  = ($total_price * $selectedInvoice->discount_percent) / 100;
        }
        else {
            $final_price = $total_price;
        }
        DB::table('invoice')->where("invoice_id" , $invoice_id)->update(['total_price' => $total_price , 'final_price' => $final_price , 'discount_price' => $discount_price]);
    }

    public function deleteProduct($id,$invoice_id){
        DB::table('invoice_sep')->where("invoice_id" , $invoice_id)->where("product_id" , $id)->delete();  
        $this->updateInvoice($invoice_id);
    }

    public function getDiscounts($invoice_id){
        $currentInvoice = DB::table('invoice')->where("invoice_id" , $invoice_id)->first();
        $discounts = DB::table('discount')->get();
        $isSelected = 0;
        $discountsDisplay = array();
        foreach ($discounts as $discount) {
            $isSelected = 0;
            if ($currentInvoice->discount_id == $discount->discount_id){
                $isSelected = 1;
            }
            $discountPush = array(
                "discount_id" => $discount->discount_id,
                "discount_code" => $discount->discount_code,
                "discount_percent" => $discount->discount_percent,
                "discount_des" => $discount->discount_des,
                "isSelected" => $isSelected
            );
            array_push($discountsDisplay,$discountPush);
   
        }
        echo json_encode($discountsDisplay , JSON_UNESCAPED_UNICODE);
    }

    public function setDiscount($discount_id, $invoice_id){
        $currentDiscount = DB::table('discount')->where("discount_id" , $discount_id)->first();
        DB::table('invoice')->where("invoice_id" , $invoice_id)->update(['discount_percent' => $currentDiscount->discount_percent ,  'discount_code' => $currentDiscount->discount_code , 'discount_id' => $currentDiscount->discount_id]);
        $this->updateInvoice($invoice_id);
    }

    public function resetDiscount($invoice_id){
        DB::table('invoice')->where("invoice_id" , $invoice_id)->update(['discount_percent' => null ,  'discount_code' => null , 'discount_id' => null]);
        $this->updateInvoice($invoice_id);   
    }

    public function prepareTable($table_id) {
        $invoice = DB::table('invoice')->insertGetId(["table_id" => $table_id , "final_price" => 0 , "total_price" => 0 , "status" => 0]);
        $setTable = DB::table('atable')->where("atable_id" , $table_id)->update(['invoice_id' => $invoice]);
        DB::table('atable')->where("atable_id" , $table_id)->update(['status' => 1]);
    }

    public function themThucDon($invoice_id , $product_id , $amount) {
        $addProduct = DB::table('product')->where("product_id" , $product_id)->first();
        $currentInvoiceID = $invoice_id;


        $checkInvoiceSep = DB::table('invoice_sep')->where("invoice_id" , $currentInvoiceID)->where("product_id" , $product_id)->first();
        if ($checkInvoiceSep == null){
            DB::table('invoice_sep')->insert(["invoice_id" => $currentInvoiceID , "product_id" => $product_id , "quantity" => $amount , "product_price" => $addProduct->product_price  ,"total_price" => $addProduct->product_price]);
        
        }
        else { 
            $currentInvoiceSep = DB::table('invoice_sep')->where("invoice_id" , $currentInvoiceID)->where("product_id" , $product_id)->first();
            DB::table('invoice_sep')->where("invoice_id" , $currentInvoiceID)->where("product_id" , $product_id)->update(["quantity" => ($currentInvoiceSep->quantity + $amount) , "total_price" => (($currentInvoiceSep->product_price) * ($currentInvoiceSep->quantity+$amount)) ]);
        }
        $this->updateInvoice($invoice_id);
    }

    public function huyThucDon($invoice_id){
        DB::table('invoice')->where("invoice_id" , $invoice_id)->update(["status" => 2]);
        DB::table('invoice_sep')->where("invoice_id" , $invoice_id)->delete();
        DB::table('atable')->where("invoice_id" , $invoice_id)->update(['status' => 0]);
        DB::table('atable')->where("invoice_id" , $invoice_id)->update(["invoice_id" => null]);    
    }

    public function getSeparateTable($table_id) {
        $table = DB::table('atable')->where("atable_id" , $table_id)->first();
        echo json_encode($table , JSON_UNESCAPED_UNICODE);
    }

    public function thanhToan($invoice_id) {
        DB::table('invoice')->where("invoice_id" , $invoice_id)->update(['status' => 1]);
        DB::table('atable')->where("invoice_id" , $invoice_id)->update(['status' => 0 , 'invoice_id' => null]);
    }
}
