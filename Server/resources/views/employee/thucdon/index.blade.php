@extends('employee/layout/layout1')

@section('chonThucDon')

  <!-- Modal -->
  <div class="modal fade" id="chuyenBanModal" tabindex="-1" role="dialog" aria-labelledby="chuyenBanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="chuyenBanModalLabel">Chuyển bàn</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input class="form-control" placeholder="Nhập vào tên bàn" id="chuyenGhepBanInput">
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Tên bàn</th>
                <th scope="col">Tình trạng</th>
              </tr>
            </thead>
            <tbody id="chuyenGhepBanTable">

            </tbody>
          </table>

        </div>

      </div>
    </div>
  </div>



  <!-- Modal -->
  <div class="modal fade" id="searchCategoryModal" tabindex="-1" role="dialog" aria-labelledby="searchCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="searchCategoryModalLabel">Tìm danh mục</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input placeholder="Nhập vào tên danh mục" class="form-control" id="searchCategoryInput">
            <table class="table">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên danh mục</th>
                  </tr>
                </thead>
                <tbody id="searchCategoryTable">

                </tbody>
              </table>
              

        </div>
      </div>
    </div>
  </div>



<div class="product-category-picker">
    
    @if (isset($currentCategory))
    <a href="{{ route('thucdon') }}"><button class="btn btn-light">Tất cả</button></a>
    <a href="{{ route('getDetailCategory', ['id'=>$currentCategory->category_id]) }}"><button class="btn btn-primary">{{$currentCategory->category_name}}</button></a>
    @else 
    <a href="{{ route('thucdon') }}"><button class="btn btn-primary">Tất cả</button></a>
    @endif
    @foreach ($product_category as $index => $category)
    @if ($index == 6)
    <br>
    @endif
    @if (isset($currentCategory))
    @if ($category->category_id != $currentCategory->category_id)
    <a href="{{ route('getDetailCategory', ['id'=>$category->category_id]) }}"><button class="btn btn-light">{{$category->category_name}}</button></a> 
    @endif
    @else
    <a href="{{ route('getDetailCategory', ['id'=>$category->category_id]) }}"><button class="btn btn-light">{{$category->category_name}}</button></a> 
    @endif
    
    @endforeach
    <button class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#searchCategoryModal">...</button>
 
</div>
<div class="product-wrapper">
    @foreach ($products as $product)
   
      <div class="product-card" onclick="themMon({{$product->product_id}})">
          <img src="{{$product->product_image}}">
          <div>{{$product->product_name}}</div>
          <span class="price">{{number_format($product->product_price, 0, '', ',')}}VNĐ</span>
      </div>

    @endforeach
</div>    
@endsection

@section('thucDonDaChon')

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="searchGlobalModal" tabindex="-1" role="dialog" aria-labelledby="searchGlobalModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchGlobalModalLabel">Tìm kiếm</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input class="form-control" placeholder="Nhập vào tên sản phẩm" id="searchGlobalInput">
        <table class="table table-hover" style="cursor:default;">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Hình ảnh</th>
              <th scope="col">Tên sản phẩm</th>
              <th scope="col">Giá tiền</th>
            </tr>
          </thead>
          <tbody id="searchGlobalBody">

          </tbody>
        </table>
        
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="payModalLabel">Thanh toán</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="payModalBody">
        @if (session()->get('system_current_table_id') != "")
        <span>{{session()->get("system_current_table_name")}}</span><br><span>{{session()->get("system_current_invoice_name")}}</span>
        <table class="table table-hover" style="margin-top: 20px;">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Tên sản phẩm</th>
              <th scope="col">Số lượng</th>
              <th scope="col">Đơn giá</th>
              <th scope="col">Tổng tiền</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($invoiceDisplay as $index => $invoice)
            <tr>
                <th scope="row">{{$index + 1}}</th>
                <td>{{$invoice['productName']}}</td>
                <td>
                   
                    <input class="ammoutInput" value="{{$invoice['quantity']}}" disabled>
                   
                </td>
                <td>{{number_format($invoice['productPrice'], 0, '', ',')}}VNĐ</td>
                <td>{{number_format($invoice['totalPrice'], 0, '', ',')}}VNĐ</td>
                
              </tr>
            @endforeach
          </tbody>
      </table>
      <h1></h1>
      <span>Thành tiền:  {{number_format($choosenInvoice->total_price, 0, '', ',')}}VNĐ</span>
      <br><hr>
      @if (session()->has('system_current_discount_code'))
      <span style="margin-top: 20px;"><i class="fa fa-terminal" aria-hidden="true"></i>Mã giảm giá: {{session()->get('system_current_discount_code')}}</span>
      @else 
      <span style="margin-top: 20px;"><i class="fa fa-terminal" aria-hidden="true"></i>Mã giảm giá: Không có</span>
      @endif
      <br><hr>
      @if (session()->has('system_current_discount_percent'))

      <span><i class="fa fa-percent" aria-hidden="true"></i>Phần trăm giảm giá: {{session()->get('system_current_discount_percent')}}%</span>
      @else 
      <span><i class="fa fa-percent" aria-hidden="true"></i>Phần trăm giảm giá: 0%</span>
      @endif
      <br><hr>
      <span><i class="fa fa-gift" aria-hidden="true"></i>Số tiền được giảm: {{number_format($choosenInvoice->discount_price, 0, '', ',')}}VNĐ</span>
      <br><hr>
      <span><i class="fa fa-money" aria-hidden="true"></i>Tổng khách hàng phải trả: {{number_format($choosenInvoice->final_price, 0, '', ',')}}VNĐ</span>    
      @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="printInvoice()">In</button>
        <a href="{{ route('thanhToan') }}"> <button type="button" class="btn btn-primary">Thanh toán</button></a>
      </div>
    </div>
  </div>
</div>
<h3 class="menu-header">Thực đơn</h3>
@if (session()->get('system_current_table_id') != "")

<span class="room-header">{{session()->get("system_current_table_name")}}</span><span class="invoice-header">{{session()->get("system_current_invoice_name")}}</span>
<a href="{{ route('huyThucDon', ['id'=>session()->get("system_current_invoice_id")]) }}"><button class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i>Hủy thực đơn</button></a>

<br><br>
<button class="btn btn-success"  data-toggle="modal" data-target="#payModal"><i class="fa fa-money" aria-hidden="true"></i>Thanh toán</button>
<button class="btn btn-info" data-toggle="modal" data-target="#chuyenBanModal"><i class="fa fa-arrows" aria-hidden="true"></i>Chuyển ghép bàn</button>

<table class="table table-hover" style="margin-top: 20px;">

    <tbody>
      @foreach ($invoiceDisplay as $index => $invoice)
      <tr>
          <th scope="row">{{$index + 1}}</th>
          <td>{{$invoice['productName']}}</td>
          <td>
              <a href="{{ route('giamSoLuong', ['id'=>$invoice['productID']]) }}"><input type="button" value="-" class="decreaseVal"></a>
              <input class="ammoutInput" value="{{$invoice['quantity']}}" disabled>
              <a href="{{ route('themSoLuong', ['id'=>$invoice['productID']]) }}"><input type="button" value="+" class="increaseVal"></a>
          </td>
          <td>{{number_format($invoice['productPrice'], 0, '', ',')}}VNĐ</td>
          <td>{{number_format($invoice['totalPrice'], 0, '', ',')}}VNĐ</td>
          <td><a href="{{ route('deleteInvoiceProduct', ['id'=>$invoice['productID']]) }}"><button class="btn btn-danger">x</button></a></td>
        </tr>
      @endforeach
    </tbody>
</table>
<label for="cars">Chọn mã giảm giá: </label>

<select id="discount_selection" style="padding: 10px">
  <option value="reset"></option>
  
  @foreach ($getDiscounts as $discount)
  @if ($discount->discount_id == Session()->get('system_current_discount_id'))
  <option selected value="{{$discount->discount_id}}">{{$discount->discount_code . " - Mã giảm " . $discount->discount_percent . "% - " . $discount->discount_des}}</option>
  @else 
  <option value="{{$discount->discount_id}}">{{$discount->discount_code . " - Mã giảm " . $discount->discount_percent . "% - " . $discount->discount_des}}</option>
  @endif
  
  @endforeach


</select>
<h1>Thành tiền:  {{number_format($choosenInvoice->total_price, 0, '', ',')}}VNĐ</h1>
@if (session()->has('system_current_discount_code'))
<h4 style="margin-top: 20px;"><i class="fa fa-terminal" aria-hidden="true"></i>Mã giảm giá: {{session()->get('system_current_discount_code')}}</h4>
@else 
<h4 style="margin-top: 20px;"><i class="fa fa-terminal" aria-hidden="true"></i>Mã giảm giá: Không có</h4>
@endif

@if (session()->has('system_current_discount_percent'))

<h4><i class="fa fa-percent" aria-hidden="true"></i>Phần trăm giảm giá: {{session()->get('system_current_discount_percent')}}%</h4>
@else 
<h4><i class="fa fa-percent" aria-hidden="true"></i>Phần trăm giảm giá: 0%</h4>
@endif

<h4><i class="fa fa-gift" aria-hidden="true"></i>Số tiền được giảm: {{number_format($choosenInvoice->discount_price, 0, '', ',')}}VNĐ</h4>

<h1><i class="fa fa-money" aria-hidden="true"></i>Tổng khách hàng phải trả: {{number_format($choosenInvoice->final_price, 0, '', ',')}}VNĐ</h1>    

@else 
<img src="{{ asset('frontend/emptytable.png') }}" style="max-width: 100%; max-width: 100%; display: block; margin-left: auto; margin-right: auto;">
<h1 style="text-align: center">Bạn chưa chọn bàn nào!!!</h1>
@endif

@endsection

@section('scripts')
    <script>
        @if(session()->get('system_current_table_id') != "")
        var currentTableID = {{session()->get('system_current_table_id')}};
        @else 
        var currentTableID;
        @endif
        
        $(document).ready(function(){
            $('#searchCategoryInput').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    $.ajax({
                        method:"POST",    
                        url:"{{ route('searchCategoryAjax') }}",
                        data:{categoryName:query , _token:CSRF_TOKEN},
                        success:function(data){ 
                            $('#searchCategoryTable').fadeIn();  
                            $('#searchCategoryTable').html(data); 
                        }
                    });    
                }
            });

            $('#chuyenGhepBanInput').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    $.ajax({
                        method:"POST",    
                        url:"{{ route('chuyenBanAjax') }}",
                        data:{tableName:query , _token:CSRF_TOKEN},
                        success:function(data){ 
                            $('#chuyenGhepBanTable').fadeIn();  
                            $('#chuyenGhepBanTable').html(data); 
                        }
                    });    
                }
            });

            
            $('#searchGlobalInput').keyup(function(){
                var query = $(this).val();
                if(query != '')
                {
                    $.ajax({
                        method:"POST",    
                        url:"{{ route('timKiem') }}",
                        data:{searchParse:query , _token:CSRF_TOKEN},
                        success:function(data){ 
                            $('#searchGlobalBody').fadeIn();  
                            $('#searchGlobalBody').html(data); 
                        }
                    });    
                }
            });
        });

        

        function themMon(id){
    
          if (currentTableID == undefined){
            alert("Bạn phải chọn phòng bàn trước!!!");
          }
          else {
            window.location.href =  "{{route('themThucDon', '')}}"+"/"+id;
          }
          
        }
          $('#discount_selection').on('change', function () {
              var discountID = $(this).val();
  
              window.location.href =   "{{route('updateDiscount', '')}}"+"/"+discountID;
          });
        
    </script>
@endsection