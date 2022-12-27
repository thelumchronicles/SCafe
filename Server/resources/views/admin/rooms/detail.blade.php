@extends('admin/layout/layout1' , ['title' => "Chi tiết phòng bàn"])

@section('content')

<!-- Modal -->
<div class="modal fade" id="getQRModal" tabindex="-1" role="dialog" aria-labelledby="getQRModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="getQRModalLabel">Mã QR</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="qrcode"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addTableModal" tabindex="-1" role="dialog" aria-labelledby="addTableModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTableModalLabel">Thêm sản phẩm mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <label>Nhập vào tên bàn: </label>
                    <input class="form-control" placeholder="Tên bàn" id="newTableName"></form>
                    
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="addTable()">Thêm bàn</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteTableModal" tabindex="-1" role="dialog" aria-labelledby="deleteTableModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTableModalLabel">Xóa bàn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 id="confrimDeleteText"></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="deleteTable()">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editTableModal" tabindex="-1" role="dialog" aria-labelledby="editTableModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTableModalLabel">Sửa bàn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <label>Nhập vào tên bàn: </label>
                    <input class="form-control" placeholder="Tên bàn" id="editedTableName"></form>
       
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="editTable()">Sửa bàn</button>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-md-12">
        <div class="card ">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">Những bàn có trong phòng bàn: {{$room->room_name}}</h4>
                <button class="btn btn-info" data-toggle="modal" data-target="#addTableModal"><i class="material-icons">add</i> Thêm bàn mới </button>
                <a href="{{ route('roomIndex') }}" ><button class="btn btn-light"><i class="material-icons">arrow_back</i> Quay về</button></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>STT</th>
                                <th>Tên bàn</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($atables as $index => $atable)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>{{$atable->atable_name}}</td>
                                <td>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteTableModal" data-atableid="{{$atable->atable_id}}" data-atablename="{{$atable->atable_name}}" onclick="deleteTableModal(this)">Xóa</button>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#editTableModal" data-atableid="{{$atable->atable_id}}" data-atablename="{{$atable->atable_name}}"  onclick="editTableModal(this)">Sửa</button>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#getQRModal" data-atableid="{{$atable->atable_id}}" data-atablename="{{$atable->atable_name}}" onclick="createQR(this)">Tạo mã QR</button>
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
var currentRoomID = {{$room->room_id}};
 var currentTableID;
    function addTable(){
        $.ajax({
            url: '{{ route('addTable') }}',
            type: 'POST',
            data: { _token: CSRF_TOKEN, roomID: currentRoomID, newTableName: $("#newTableName").val() },
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

    function deleteTableModal(evt){
        $("#confrimDeleteText").html("Bạn có chắc chắn muốn xóa bàn: <span style='font-weight: 700'>" + $(evt).data("atablename") + "</span> không?");
        currentTableID = $(evt).data("atableid");

    }

    function createQR(evt){
        document.getElementById("qrcode").innerHTML = "";
        $('#getQRModalLabel').html("Mã QR của bàn: " + $(evt).data('atablename'));
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            width : 300,
            height : 300
        });
        qrcode.makeCode($(evt).data('atableid').toString());
    }
    function deleteTable(){
        $.ajax({
            url: '{{ route('deleteTable') }}',
            type: 'POST',
            data: { _token: CSRF_TOKEN, tableID: currentTableID },
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

    function editTableModal(evt){
        currentTableID = $(evt).data('atableid');
        $('#editedTableName').val($(evt).data('atablename'));
    }

    function editTable(){
        $.ajax({
            url: '{{ route('editTable') }}',
            type: 'POST',
            data: { _token: CSRF_TOKEN, tableID: currentTableID ,  editedTableName: $('#editedTableName').val() },
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

</script>


@endsection