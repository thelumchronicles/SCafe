@extends('admin/layout/layout1' , ['title' => "Danh mục của món ăn"])

@section('content')

<!-- Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Tạo danh mục mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form>
                    <label>Nhập vào tên danh mục mới: </label>
                    <input type="text" class="form-control" id="foodCategoryName"
                        placeholder="Nhập tên danh mục vào đây.">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="addFoodCategory()">Thêm danh mục</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteCategoryModal" tabindex="-1" role="dialog" aria-labelledby="deleteCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Xác nhận</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 id="confrimText">Bạn có chắc chắn muốn xóa danh mục: </h3>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="postDeleteCategory()">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Chỉnh sửa danh mục: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Nhập tên của danh mục mới: </label>
                <input class="form-control" value="" id="currentCategoryName">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="postEditCategory()">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="card ">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">Danh mục của món ăn</h4>
                <button class="btn btn-info" data-toggle="modal" data-target="#addCategoryModal"><i class="material-icons">add</i>Tạo danh mục
                    mới</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>STT</th>
                                <th>Tên danh mục</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($product_category as $index => $category)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td><a href="{{ route('detailCategory', ['id'=>$category->category_id]) }}"> {{$category->category_name}} </a></td>
                                <td>
                                    <button class="btn btn-danger" style="padding: 10px" data-toggle="modal"
                                        class="openDeleteDialog" data-id="{{$category->category_id}}"
                                        data-categoryname="{{$category->category_name}}"
                                        data-target="#deleteCategoryModal" onclick="openDeleteDialog(this)">Xóa</button>
                                    <button class="btn btn-primary" style="padding: 10px" data-toggle="modal"
                                        data-target="#editCategoryModal" data-id="{{$category->category_id}}"
                                        data-categoryname="{{$category->category_name}}"
                                        onclick="openEditDialog(this)">Sửa</button>
                                </td>
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
    var categoryCurrentID;


    function postDeleteCategory() {
        $.ajax({
            url: '{{ route('postDeleteFoodCategory') }}',
            type: 'POST',
            data: { _token: CSRF_TOKEN, id: categoryCurrentID },
            success: function (data) {
                if (data === "Success") {
                    notify("Xóa thành công" , 'success');
                    setTimeout(function () { location.reload() }, 1000);
                }
                else {
                    notify(data , 'danger');
                }
            }
        });
    }

    function postEditCategory() {
        if ($("#currentCategoryName").val().trim() === "") {
            notify("Bạn chưa nhập tên danh mục" , 'danger');
        }
        else {
            $.ajax({
                url: '{{ route('postEditFoodCategory') }}',
                type: 'POST',
                data: { _token: CSRF_TOKEN, categoryID: categoryCurrentID, categoryName: $('#currentCategoryName').val() },
                success: function (data) {
                    if (data === "Success") {
                        notify("Thêm thành công" , 'success');
                        setTimeout(function () { location.reload() }, 1000);
                    }
                    else {
                        notify(data , 'danger');
                    }
                }
            });
        }

    }


    function openDeleteDialog(evt) {
        var categoryName = $(evt).data('categoryname');
        categoryCurrentID = $(evt).data('id');
        $("#confrimText").html("Bạn có chắc chắn muốn xóa danh mục: " + '<span style="font-weight: 800">' + categoryName + '</span>' + " không?");
    }

    function openEditDialog(evt) {
        categoryCurrentID = $(evt).data('id');
        var categoryName = $(evt).data('categoryname');
        $("#currentCategoryName").val(categoryName);
        $("#currentCategoryNameLabel").html("Chỉnh sửa danh mục: " + categoryName);
        $("#editCategoryModalLabel").html("Sửa danh mục: " + categoryName);
    }

    function addFoodCategory() {

        if ($('#foodCategoryName').val().trim() === "") {
            notify("Bạn chưa nhập tên danh mục" , 'danger');
        }
        else {
            $.ajax({
                url: '{{ route('postAddFoodCategory') }}',
                type: 'POST',
                data: { _token: CSRF_TOKEN, categoryName: $('#foodCategoryName').val() },
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