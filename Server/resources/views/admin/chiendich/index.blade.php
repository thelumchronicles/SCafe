@extends('admin/layout/layout1' , ['title' => "Chiến dịch"])

@section('content')

<!-- Modal -->
<div class="modal fade" id="createDiscountModal" tabindex="-1" role="dialog" aria-labelledby="createDiscountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createDiscountModalLabel">Thêm chiến dịch mới</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <label>Tên chiến dịch mới</label>
          <input class="form-control" id="discountName">
          <label>Mã giảm</label>
          <input class="form-control" id="discountCode">
          <label>Phần trăm giảm</label>
            <input class="form-control" type="number" min="1" max="100" id="discountPercent">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="createDiscount()">Tạo</button>
        </div>
      </div>
    </div>
  </div>


<div class="row">

    <div class="col-md-12">
        <div class="card ">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">Tổng quan chiến dịch</h4>
                <button class="btn btn-info" data-toggle="modal" data-target="#createDiscountModal"><i class="material-icons">add</i>Tạo chiến dịch mới</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>STT</th>
                                <th>Mô tả chiến dịch</th>
                                <th>Mã giảm</th>
                                <th>Phần trăm giảm</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($discounts as $index => $discount)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>{{$discount->discount_des}}</td>
                                <td>{{$discount->discount_code}}</td>
                                <td>{{$discount->discount_percent}}%</td>
                                <td><a href="{{ route('xoaChienDich', ['id'=>$discount->discount_id]) }}"><button class="btn btn-danger">Xóa</button></a></td>
                            </tr>
                            @endforeach
            
                      
                            


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
    <script>
        function createDiscount(){
            var discountDes = $("#discountName").val();
            var discountCode = $("#discountCode").val();
            var discountPercent = $("#discountPercent").val();
            $.ajax({
                url: '{{ route('themChienDich') }}',
                type: 'POST',
                data: { _token: CSRF_TOKEN, discountDes: discountDes , discountCode:discountCode ,discountPercent:discountPercent},
                success: function (data) {
                    if (data === "Success") {
                        notify('Thêm thành công' , 'success');
                        setTimeout(function () { location.reload() }, 1000);
                    }
                    else {
                        notify(data , 'danger');
                    }            
                }
            });
        }
    </script>
@endsection