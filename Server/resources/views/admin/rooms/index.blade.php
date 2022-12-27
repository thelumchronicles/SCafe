@extends('admin/layout/layout1' , ['title' => "Quản lý phòng bàn"])

@section('content')

<!-- Add Room -->
<div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog" aria-labelledby="addRoomModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRoomModalLabel">Tạo phòng bàn mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Tên phòng bàn mới</label>
                <input class="form-control" id="newRoomName">
      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="addRoom()">Thêm phòng bàn mới</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Room -->
<div class="modal fade" id="editRoomModal" tabindex="-1" role="dialog" aria-labelledby="editRoomModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRoomModalLabel">Sửa phòng bàn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label>Tên phòng bàn mới</label>
                <input class="form-control" id="editedRoomName">
      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="editRoom()">Sửa phòng bàn</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Room -->
<div class="modal fade" id="deleteRoomModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoomModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteRoomModalLabel">Xóa phòng bàn</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 id="confrimDeleteText"></h3>
      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="deleteRoom()">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card ">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Phòng bàn</h4>
                    <button class="btn btn-info" data-toggle="modal" data-target="#addRoomModal"><i class="material-icons">add</i> Thêm phòng bàn mới </button>
                
            
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="text-primary">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên phòng bàn</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rooms as $index => $room)
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td><a href="{{ route('detailRoom', ['id'=>$room->room_id]) }}">{{$room->room_name}}</a></td>
                                        <td>
                                            <button class="btn btn-danger"  data-toggle="modal" data-target="#deleteRoomModal" data-roomid="{{$room->room_id}}" data-roomname="{{$room->room_name}}" onclick="deleteRoomModal(this)">Xóa</button>
                                            <button class="btn btn-primary"  data-toggle="modal" data-target="#editRoomModal" data-roomid="{{$room->room_id}}" data-roomname="{{$room->room_name}}" onclick="editRoomModal(this)">Sửa</button>
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
    var currentRoomID;
    function addRoom(){
        $.ajax({
            url: '{{ route('addRoom') }}',
            type: 'POST',
            data: { _token: CSRF_TOKEN, newRoomName: $("#newRoomName").val() },
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

    function deleteRoomModal(evt){
        $("#confrimDeleteText").html("Bạn có chắc chắn muốn xóa phòng bàn: <span style='font-weight: 700'>" + $(evt).data("roomname") + "</span> không?");
        currentRoomID = $(evt).data("roomid");

    }

    function deleteRoom(){
        $.ajax({
            url: '{{ route('deleteRoom') }}',
            type: 'POST',
            data: { _token: CSRF_TOKEN, roomID: currentRoomID },
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

    function editRoomModal(evt){
        currentRoomID = $(evt).data('roomid');
        $('#editedRoomName').val($(evt).data('roomname'));
    }

    function editRoom(){
        $.ajax({
            url: '{{ route('editRoom') }}',
            type: 'POST',
            data: { _token: CSRF_TOKEN, roomID: currentRoomID ,  editedRoomName: $('#editedRoomName').val() },
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