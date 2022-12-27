@extends('admin/layout/layout1' , ['title' => "Chi tiết danh mục"])

@section('content')

<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <label>Nhập vào tên mặt hàng mới: </label>
                    <input class="form-control" placeholder="Tên mặt hàng" id="newProductName"></form>
                    <label>Hình ảnh sản phẩm: </label>
                    <input class="form-control" type="file" id="newProductImage">
                    <label>Nhập vào giá tiền: </label>
                    <input class="form-control" type="number" id="newProductPrice">
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="addNewProduct()">Thêm sản phẩm</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal-->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Sửa mặt hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <label>Nhập vào tên mặt hàng mới: </label>
                    <input class="form-control" placeholder="Tên mặt hàng" id="editedProductName"></form>
                    <label>Hình ảnh sản phẩm: </label>
                    <img style="width: 80px" src="" id="editedProductImagePreviewer">
                    
                    <input class="form-control" type="file" id="editedProductImage">
                    <label>Nhập vào giá tiền: </label>
                    <input class="form-control" type="number" id="editedProductPrice">
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="editProduct()">Sửa sản phẩm</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Product Modal-->
<div class="modal fade" id="deleteProductModal" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Xóa mặt hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 id="confrimDeleteText"> </h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="deleteProduct()">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="card ">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">Những mặt hàng có trong danh mục: {{$category->category_name}}</h4>
                <button class="btn btn-info" data-toggle="modal" data-target="#addProductModal"><i class="material-icons">add</i> Thêm mặt hàng mới </button>
                <a href="{{ route('foodCategory') }}"><button class="btn btn-light"><i class="material-icons">arrow_back</i> Quay về</button></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>STT</th>
                                <th>Hình ảnh</th>
                                <th>Tên mặt hàng</th>
                                <th>Giá tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $index => $product)
                                <tr>
                                    <td>{{$index + 1}}</td>
                                    <td><img src="{{$product->product_image}}" style="width: 80px"></td>
                                    <td>{{$product->product_name}}</td>
                                    <td>{{$product->product_price}}</td>
                                    <td>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteProductModal" data-productid="{{$product->product_id}}" data-productname="{{$product->product_name}}" onclick="deleteProductModal(this)">Xóa</button>
                                        <button class="btn btn-info" onclick="editProductModal(this)"
                                                data-target="#editProductModal"
                                                data-productid="{{$product->product_id}}"
                                                data-productimage="{{$product->product_image}}"
                                                data-productname="{{$product->product_name}}"
                                                data-productprice="{{$product->product_price}}"
                                                data-toggle="modal" data-target="#editProductModal">Sửa</button>
                                    </td>
                                <tr>
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
        var currentCategoryID = {{$id}};
        var currentProductID;
        function editProductModal(evt){
            $('#editedProductName').val($(evt).data('productname'));
            $('#editedProductImagePreviewer').attr("src",$(evt).data('productimage'));
            $('#editedProductPrice').val($(evt).data('productprice'));
            currentProductID = $(evt).data('productid')
        }

        function deleteProductModal(evt) {
            $('#confrimDeleteText').html("Bạn có chắc chắn muốn xóa mặt hàng <span style='font-weight:700'>" + $(evt).data('productname') + "</span> không?" );
            currentProductID = $(evt).data('productid');
        }


        function deleteProduct(){
            $.ajax({
                url: '{{ route('deleteProduct') }}',
                type: 'POST',
                data: { _token: CSRF_TOKEN, productID: currentProductID },
                success: function (data) {
                    if (data === "Success") {
                        notify('Xóa thành công' , 'success');
                        setTimeout(function () { location.reload() }, 1000);
                    }
                    else {
                        notify(data , 'danger');
                    }            
                }
            });
        }

        function editProduct(){
            if($('#editedProductName').val().trim() === "" || $('#editedProductPrice').val().trim() === "") {
                notify("Bạn phải nhập đủ trường" , 'danger');
            }
            else {
                var formData = new FormData();
                var imageFile = $("#editedProductImage")[0].files[0];
                if ($("#editedProductImage").val()){
                    formData.append('imgInp', imageFile);
                }
                formData.append('productID' , currentProductID);
                formData.append('editedProductName',$('#editedProductName').val());
                formData.append('editedProductPrice',$('#editedProductPrice').val());
                formData.append('_token', CSRF_TOKEN);
                $.ajax({
                    url: '{{ route('editProduct') }}',
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (data) {
                        if (data === "Success") {
                            notify('Sửa thành công' , 'success');
                            setTimeout(function () { location.reload() }, 1000);
                        }
                        else {
                            notify(data , 'danger');
                        }            
                    }
                });

            }
        }


        function addNewProduct(){
            if($('#newProductName').val().trim() === "" || $('#newProductPrice').val().trim() === "") {
                notify("Bạn phải nhập đủ trường" , 'danger');
            }
            else {
                var formData = new FormData();
                var imageFile = $("#newProductImage")[0].files[0];
                if ($("#newProductImage").val()){
                    formData.append('imgInp', imageFile);
                }
                formData.append('newProductName',$('#newProductName').val());
                formData.append('newProductPrice',$('#newProductPrice').val());
                formData.append('currentCategoryID' , currentCategoryID)
                formData.append('_token', CSRF_TOKEN);
                $.ajax({
                    url: '{{ route('addProduct') }}',
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    data: formData,
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
        }
    </script>

@endsection