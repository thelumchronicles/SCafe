<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class EmployeeController extends Controller
{

    
    public function getPhongBan(){
        $getDiscounts = DB::table('discount')->get();
        $choosenInvoice = DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->first();
        $currentInvoices = DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->get();
        $invoiceDisplay = []; 
       



        foreach ($currentInvoices as $invoice){
            $invoiceProduct = DB::table('product')->where("product_id" , $invoice->product_id)->first();
            $invoicePush = array (
                'productID' => $invoice->product_id,
                'productName' => $invoiceProduct->product_name,
                'quantity' => $invoice->quantity,
                'productPrice' => $invoice->product_price,
                'totalPrice' => $invoice->total_price,
                'finalPrice' => $choosenInvoice->final_price,
            );
    
            array_push($invoiceDisplay, $invoicePush);
        }
        
        $rooms = DB::table('room')->take(12)->get();
        $atables = DB::table('atable')->get();
        $atablesDisplay = [];
        foreach ($atables as $atable) {
            $invoiceOfTable = DB::table('invoice')->where("invoice_id" , $atable->invoice_id)->first();
            $finalPriceOfTable = 0;
            if ($invoiceOfTable != null) {
                $finalPriceOfTable = $invoiceOfTable->final_price;
            }
            $atablePush = array (
                'tableID' => $atable->atable_id,
                'tableName' => $atable->atable_name,
                'tableStatus' => $atable->status,
                'tablePrice' => $finalPriceOfTable,
            );
            array_push($atablesDisplay, $atablePush);
        }
        return view("employee/phongban/index" , compact("rooms" , "atablesDisplay" , 'invoiceDisplay' , 'choosenInvoice' , 'getDiscounts'));
    }


    public function getPhongBanWithOptions($type){
        $getDiscounts = DB::table('discount')->get();
        $choosenInvoice = DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->first();
        $currentInvoices = DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->get();
        $invoiceDisplay = []; 
       



        foreach ($currentInvoices as $invoice){
            $invoiceProduct = DB::table('product')->where("product_id" , $invoice->product_id)->first();
            $invoicePush = array (
                'productID' => $invoice->product_id,
                'productName' => $invoiceProduct->product_name,
                'quantity' => $invoice->quantity,
                'productPrice' => $invoice->product_price,
                'totalPrice' => $invoice->total_price,
                'finalPrice' => $choosenInvoice->final_price,
            );
    
            array_push($invoiceDisplay, $invoicePush);
        }
        
        $rooms = DB::table('room')->take(12)->get();
        $atables = DB::table('atable')->where("status" , $type)->get();
        $atablesDisplay = [];
        foreach ($atables as $atable) {
            $invoiceOfTable = DB::table('invoice')->where("invoice_id" , $atable->invoice_id)->first();
            $finalPriceOfTable = 0;
            if ($invoiceOfTable != null) {
                $finalPriceOfTable = $invoiceOfTable->final_price;
            }
            $atablePush = array (
                'tableID' => $atable->atable_id,
                'tableName' => $atable->atable_name,
                'tableStatus' => $atable->status,
                'tablePrice' => $finalPriceOfTable,
            );
            array_push($atablesDisplay, $atablePush);
        }
        return view("employee/phongban/index" , compact("rooms" , "atablesDisplay" , 'invoiceDisplay' , 'choosenInvoice' , 'getDiscounts' , 'type'));
    }


    public function getThucDon(){
        $getDiscounts = DB::table('discount')->get();
        $choosenInvoice = DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->first();
        $currentInvoices = DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->get();
        $invoiceDisplay = []; 
       



        foreach ($currentInvoices as $invoice){
            $invoiceProduct = DB::table('product')->where("product_id" , $invoice->product_id)->first();
            $invoicePush = array (
                'productID' => $invoice->product_id,
                'productName' => $invoiceProduct->product_name,
                'quantity' => $invoice->quantity,
                'productPrice' => $invoice->product_price,
                'totalPrice' => $invoice->total_price,
                'finalPrice' => $choosenInvoice->final_price
            );
    
            array_push($invoiceDisplay, $invoicePush);
        }
        
        $products = DB::table('product')->get();
        $product_category = DB::table('product_category')->take(12)->get();
        return view('employee/thucdon/index' , compact('product_category' , 'products' , 'invoiceDisplay' , 'choosenInvoice' , 'getDiscounts'));
    }

    public function getDetailCategory($id){
        $getDiscounts = DB::table('discount')->get();
        $choosenInvoice = DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->first();
        $currentInvoices = DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->get();
        $invoiceDisplay = []; 
       



        foreach ($currentInvoices as $invoice){
            $invoiceProduct = DB::table('product')->where("product_id" , $invoice->product_id)->first();
            $invoicePush = array (
                'productID' => $invoice->product_id,
                'productName' => $invoiceProduct->product_name,
                'quantity' => $invoice->quantity,
                'productPrice' => $invoice->product_price,
                'totalPrice' => $invoice->total_price,
                'finalPrice' => $choosenInvoice->final_price
            );
    
            array_push($invoiceDisplay, $invoicePush);
        }





        $product_category = DB::table('product_category')->take(12)->get();
        $products = DB::table('product')->where("category_id" , $id)->get();
        $currentCategory = DB::table('product_category')->where('category_id' , $id)->first();
        if ($currentCategory == null) {
            return redirect()->route('errorPage2');
        }
        
        return view('employee/thucdon/index' , compact('product_category' , 'products' , 'currentCategory' , 'invoiceDisplay' , 'choosenInvoice' , 'getDiscounts'));
    }

    public function searchCategoryAjax(Request $res){
        $ajaxHTML = "";
        $categories = DB::table('product_category')->where("category_name" , "LIKE" ,  "%{$res->categoryName}%" )->get();
        foreach($categories as $index => $category) {
            $ajaxHTML .= 
            '<tr>
                <th scope="row">'. ($index + 1) . '</th>' . 
                '<th><a href = "' . route('getDetailCategory', ['id' => $category->category_id]) . '">' . $category->category_name . ' </a>'  . '</th>' . 
            '<tr>';
        }
        echo $ajaxHTML;
    }

    public function getRoomDetail($id){
        $getDiscounts = DB::table('discount')->get();
        $choosenInvoice = DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->first();
        $currentInvoices = DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->get();
        $invoiceDisplay = []; 
       



        foreach ($currentInvoices as $invoice){
            $invoiceProduct = DB::table('product')->where("product_id" , $invoice->product_id)->first();
            $invoicePush = array (
                'productID' => $invoice->product_id,
                'productName' => $invoiceProduct->product_name,
                'quantity' => $invoice->quantity,
                'productPrice' => $invoice->product_price,
                'totalPrice' => $invoice->total_price,
                'finalPrice' => $choosenInvoice->final_price
            );
    
            array_push($invoiceDisplay, $invoicePush);
        }

        $currentRoom = DB::table('room')->where("room_id" , $id)->first();
        if ($currentRoom == null) {
            return redirect()->route("errorPage2");
        }
        
        $rooms = DB::table('room')->take(12)->get();
        $atables = DB::table('atable')->where("room_id" , $id)->get();

        $atablesDisplay = [];
        foreach ($atables as $atable) {
            $invoiceOfTable = DB::table('invoice')->where("invoice_id" , $atable->invoice_id)->first();
            $finalPriceOfTable = 0;
            if ($invoiceOfTable != null) {
                $finalPriceOfTable = $invoiceOfTable->final_price;
            }
            $atablePush = array (
                'tableID' => $atable->atable_id,
                'tableName' => $atable->atable_name,
                'tableStatus' => $atable->status,
                'tablePrice' => $finalPriceOfTable,
            );
            array_push($atablesDisplay, $atablePush);
        }
        return view("employee/phongban/index" , compact("rooms" , "atablesDisplay" , "currentRoom" , 'invoiceDisplay', 'getDiscounts' , 'choosenInvoice'));
    }

    public function getRoomDetailWithOptions($id,$type){
        $getDiscounts = DB::table('discount')->get();
        $choosenInvoice = DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->first();
        $currentInvoices = DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->get();
        $invoiceDisplay = []; 
       



        foreach ($currentInvoices as $invoice){
            $invoiceProduct = DB::table('product')->where("product_id" , $invoice->product_id)->first();
            $invoicePush = array (
                'productID' => $invoice->product_id,
                'productName' => $invoiceProduct->product_name,
                'quantity' => $invoice->quantity,
                'productPrice' => $invoice->product_price,
                'totalPrice' => $invoice->total_price,
                'finalPrice' => $choosenInvoice->final_price
            );
    
            array_push($invoiceDisplay, $invoicePush);
        }

        $currentRoom = DB::table('room')->where("room_id" , $id)->first();
        if ($currentRoom == null) {
            return redirect()->route("errorPage2");
        }
        
        $rooms = DB::table('room')->take(12)->get();
        $atables = DB::table('atable')->where("room_id" , $id)->where("status" , $type)->get();

        $atablesDisplay = [];
        foreach ($atables as $atable) {
            $invoiceOfTable = DB::table('invoice')->where("invoice_id" , $atable->invoice_id)->first();
            $finalPriceOfTable = 0;
            if ($invoiceOfTable != null) {
                $finalPriceOfTable = $invoiceOfTable->final_price;
            }
            $atablePush = array (
                'tableID' => $atable->atable_id,
                'tableName' => $atable->atable_name,
                'tableStatus' => $atable->status,
                'tablePrice' => $finalPriceOfTable,
            );
            array_push($atablesDisplay, $atablePush);
        }
        return view("employee/phongban/index" , compact("rooms" , "atablesDisplay" , "currentRoom" , 'invoiceDisplay', 'getDiscounts' , 'choosenInvoice' , 'type'));
    }

    public function setTable($id){
        $setTable = DB::table('atable')->where("atable_id" , $id)->first();
        if ($setTable == null) {
            return redirect()->route("errorPage2");
        }
        else {
            $roomOfTable = DB::table('room')->where("room_id" , $setTable->room_id)->first();
            Session::put('system_current_table_id', $id);
            Session::put('system_current_table_name', $roomOfTable->room_name . " - " . $setTable->atable_name);

            if ($setTable->invoice_id == null) {
            
                $invoice = DB::table('invoice')->insertGetId(["table_id" => $id , "final_price" => 0 , "total_price" => 0 , "status" => 0]);
                $setTable = DB::table('atable')->where("atable_id" , $id)->update(['invoice_id' => $invoice]);
                Session::put('system_current_invoice_id', $invoice);
                Session::put('system_current_invoice_name', "invoice - scafe" . $invoice);
                DB::table('atable')->where("atable_id" , $id)->update(['status' => 1]);
            }
            else {
                Session::put('system_current_invoice_id', $setTable->invoice_id);
                Session::put('system_current_invoice_name', "invoice - scafe" . $setTable->invoice_id);
                $currentInvoiceOfTable = DB::table("invoice")->where('invoice_id' , $setTable->invoice_id)->first();
                session()->put('system_current_discount_id' , $currentInvoiceOfTable->discount_id);
                session()->put('system_current_discount_code' , $currentInvoiceOfTable->discount_code);
                session()->put('system_current_discount_percent' , $currentInvoiceOfTable->discount_percent);
            }




            return redirect()->route("thucdon");
        }
    }

    public function huyThucDon($id){
        DB::table('invoice')->where("invoice_id" , $id)->update(["status" => 2]);
        DB::table('invoice_sep')->where("invoice_id" , $id)->delete();
        DB::table('atable')->where("invoice_id" , $id)->update(['status' => 0]);
        DB::table('atable')->where("invoice_id" , $id)->update(["invoice_id" => null]);
      
        session()->forget('system_current_table_id');
        session()->forget('system_current_table_name');
        session()->forget('system_current_invoice_id');
        session()->forget('system_current_invoice_name');
        
        return redirect()->route("employeeIndex");
    }

    public function themThucDon($id){
       
        $addProduct = DB::table('product')->where("product_id" , $id)->first();
        if ($addProduct == null){
            return redirect()->route("errorPage2");
        }
        $currentInvoiceID = session()->get("system_current_invoice_id");
        if ($currentInvoiceID == ""){
            return redirect()->route("errorPage2");
        }

        $checkInvoiceSep = DB::table('invoice_sep')->where("invoice_id" , $currentInvoiceID)->where("product_id" , $id)->first();
        if ($checkInvoiceSep == null){
            DB::table('invoice_sep')->insert(["invoice_id" => $currentInvoiceID , "product_id" => $id , "quantity" => 1 , "product_price" => $addProduct->product_price  ,"total_price" => $addProduct->product_price]);
        
        }
        else { 
            $currentInvoiceSep = DB::table('invoice_sep')->where("invoice_id" , $currentInvoiceID)->where("product_id" , $id)->first();
            DB::table('invoice_sep')->where("invoice_id" , $currentInvoiceID)->where("product_id" , $id)->update(["quantity" => ($currentInvoiceSep->quantity + 1) , "total_price" => (($currentInvoiceSep->product_price) * ($currentInvoiceSep->quantity+1)) ]);
        }

        
        $this->updateInvoice();
        return redirect()->back();
        
    }

    public function themSoLuong($id){
        $currentInvoiceSep = DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->where("product_id" , $id)->first();  
        if ($currentInvoiceSep == null) {
            return redirect()->route("errorPage2");
        }
        DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->where("product_id" , $id)->update(["quantity" => $currentInvoiceSep->quantity + 1 , "total_price" => ($currentInvoiceSep->product_price * ($currentInvoiceSep->quantity + 1) )]);
        $this->updateInvoice();
        return redirect()->back();
    }


    public function giamSoLuong($id){
        $currentInvoiceSep = DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->where("product_id" , $id)->first();  
        if ($currentInvoiceSep == null) {
            return redirect()->route("errorPage2");
        }
        if ($currentInvoiceSep->quantity > 1){
            DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->where("product_id" , $id)->update(["quantity" => $currentInvoiceSep->quantity - 1 , "total_price" => ($currentInvoiceSep->product_price * ($currentInvoiceSep->quantity - 1) )]);
        }
        $this->updateInvoice();
        return redirect()->back();
    }

    public function deleteInvoiceProduct($id){
        DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->where("product_id" , $id)->delete();  
        $this->updateInvoice();
        return redirect()->back();
    }

    public function updateInvoice(){
        $selectedInvoice = DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->first();
        $total_price = 0;
        $final_price = 0;
        $discount_price = 0;
        $invoiceseps = DB::table('invoice_sep')->where("invoice_id" , session()->get("system_current_invoice_id"))->get();
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
        DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->update(['total_price' => $total_price , 'final_price' => $final_price , 'discount_price' => $discount_price]);
    }

    public function updateDiscount($id){
        if ($id == "reset") {
            session()->forget('system_current_discount_id');
            session()->forget('system_current_discount_code');
            session()->forget('system_current_discount_percent');
            DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->update(['discount_percent' => null ,  'discount_code' => null , 'discount_id' => null]);
            $this->updateInvoice();
            return redirect()->back();
        }
        $currentDiscount = DB::table('discount')->where("discount_id" , $id)->first();
        if ($currentDiscount == null) {
            DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->update(['discount_percent' => null ,  'discount_code' => null , 'discount_id' => $currentDiscount->discount_id]);
            session()->forget('system_current_discount_id');
            session()->forget('system_current_discount_code');
            session()->forget('system_current_discount_percent');
        }
        else {
            DB::table('invoice')->where("invoice_id" , session()->get("system_current_invoice_id"))->update(['discount_percent' => $currentDiscount->discount_percent ,  'discount_code' => $currentDiscount->discount_code , 'discount_id' => $currentDiscount->discount_id]);
            session()->put('system_current_discount_id' , $currentDiscount->discount_id);
            session()->put('system_current_discount_code' , $currentDiscount->discount_code);
            session()->put('system_current_discount_percent' , $currentDiscount->discount_percent);
        }
        $this->updateInvoice();
        return redirect()->back();
    }

    // public function thanhToan2(){

    //     DB::table('invoice')->where("invoice_id" , session()->get('system_current_invoice_id'))->update(['status' => 1]);

    //     session()->forget('system_current_discount_id');
    //     session()->forget('system_current_discount_code');
    //     session()->forget('system_current_discount_percent');
    //     session()->forget('system_current_table_id');
    //     session()->forget('system_current_table_name');
    //     session()->forget('system_current_invoice_id');
    //     session()->forget('system_current_invoice_name');
    //     return redirect()->back();
    // }

    public function thanhToan(){
     
        DB::table('invoice')->where("invoice_id" , session()->get('system_current_invoice_id'))->update(['status' => 1]);
        DB::table('atable')->where("atable_id" , session()->get('system_current_table_id'))->update(['status' => 0 , 'invoice_id' => null]);
        session()->forget('system_current_discount_id');
        session()->forget('system_current_discount_code');
        session()->forget('system_current_discount_percent');
        session()->forget('system_current_table_id');
        session()->forget('system_current_table_name');
        session()->forget('system_current_invoice_id');
        session()->forget('system_current_invoice_name');
 
        return redirect()->route("employeeIndex");       
    }


    public function chuyenBanAjax(Request $res){
        $atablesDisplay = [];
        $atables = DB::table('atable')->where("atable_name" , "LIKE" ,  "%{$res->tableName}%" )->get();
        
        if ($atables != null) {
            foreach ($atables as $atable) {
                $currentRoomQuery = DB::table('room')->where("room_id" , $atable->room_id)->first();
                $atablePush = array (
                    'roomID' => $atable->room_id,
                    'roomName' => $currentRoomQuery->room_name,
                    'detailTable' => [] ,
                );
                if (!in_array($atablePush, $atablesDisplay)){
          
                    array_push($atablesDisplay , $atablePush );
                }
            }
        }
        foreach ($atables as $atable) {
            foreach ($atablesDisplay as &$item) {

                if ($atable->room_id == $item['roomID']){
                    $tableStatus = 0;
                    if ($atable->status != 0) { 
                        $tableStatus = 1;
                    }
                    $atablePush = array(
                        'tableID' => $atable->atable_id,
                        'tableName' => $atable->atable_name ,
                        'tableStatus' => $tableStatus,
                        
                    );
                    array_push($item['detailTable'] , $atablePush );
                  
        
                }
            }
        }

        // dd($atablesDisplay);
        $displayHTML = "";
        foreach ($atablesDisplay as &$displayItem){
            $displayHTML .= 
            '<tr style="background: black; color: white"><td colspan="3">' . "Phòng bàn: " . $displayItem['roomName'] . '</td></tr>';
            foreach ($displayItem['detailTable'] as $index => $displayTable){
                if ($displayTable['tableStatus'] == 0) {
                    $displayHTML .= '
                    <tr>
                        <td>' . $index + 1 . '</td>
                        <td><a href="'.  route('chuyenBan', ['id' => $displayTable['tableID']])  . '">' .$displayTable['tableName']. '</a></td>
                        <td>Trống</td>
                    </tr>
                    ';
                }
                else {
                    $displayHTML .= '
                    <tr>
                        <td>' . $index + 1 . '</td>
                        <td>' .$displayTable['tableName']. '</td>
                        <td>Đã đặt</td>
                    </tr>
                    ';
                }
  


            }
        }
        echo $displayHTML;

    
    }

    public function chuyenBan($id){

        $currentTableQuery = DB::table("atable")->where("atable_id" , $id)->first();
        if ($currentTableQuery == null) {
           return redirect()->route("errorPage2");
        }
        $currentRoomOfTable = DB::table('room')->where("room_id" , $currentTableQuery->room_id)->first();
        DB::table('atable')->where("invoice_id" , session()->get("system_current_invoice_id"))->update(['invoice_id' => null , 'status' => 0]);
        DB::table('atable')->where("atable_id" , $id)->update(['invoice_id' => session()->get("system_current_invoice_id") , 'status' => 1]);
        session()->put('system_current_table_id' , $currentTableQuery->atable_id);
        session()->put('system_current_table_name' ,  $currentRoomOfTable->room_name . " - " . $currentTableQuery->atable_name);
        return redirect()->back();
    }

    public function timKiem(Request $res){

    

        $ajaxHTML = "";
        $products = DB::table('product')->where("product_name" , "LIKE" ,  "%{$res->searchParse}%")->get();
        foreach ($products as $index => $product){
            $ajaxHTML .= '<tr onclick="themMon('. $product->product_id .')">
                <th scope="row">'. ($index + 1) . '</th>' . 
                '<th><img style="width: 80px" src="'. $product->product_image .'"></th>' . 
                '<th>'.$product->product_name.'</th>'.
                '<th>'.number_format($product->product_price, 0, '', ',').'VNĐ</th>'.
            '</tr>';
        }
        echo $ajaxHTML;
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
}
