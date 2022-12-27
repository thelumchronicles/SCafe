@extends('admin/layout/layout1' , ['title' => "Quản lý tài khoản"])

<!-- Add Account -->
<div class="modal fade" id="addAccountModal" tabindex="-1" role="dialog" aria-labelledby="addAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAccountModalLabel">Thêm tài khoản mới</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label>Nhập vào tên đăng nhập: </label>
                        <input class="form-control" placeholder="Tên đăng nhập" id="newUserName">
                    </div>
                    <div class="form-group">
                        <label>Tên đầy đủ của tài khoản: </label>
                        <input class="form-control" placeholder="Tên đầy đủ" id="newUserFullName">
                    </div>
                    <div class="form-group">
                        <label>Nhâp vào mật khẩu: </label>
                        <input class="form-control" placeholder="Mật khẩu" type="password" id="newUserPassword">
                    </div>
                    <label>Hình ảnh của tài khoản: </label>
                    <input class="form-control-file" type="file" id="newUserImage">
               


                    <div class="form-group">
                        <label>Giới tính:</label>
                        <select class="form-control" id="newUserGender">
                            <option value="0">Nam</option>
                            <option value="1">Nữ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Quyền:</label>
                        <select class="form-control" id="newUserPermission">
                            <option value="0">Admin</option>
                            <option value="1">Nhân viên</option>
                            <option value="2">Nhà bếp</option>
                        </select>
                    </div>
                </form>    
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="addAccount()">Thêm tài khoản</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal-->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Xác nhận</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
                <h3 id="confrimDeleteText"></h3>
                <span class="text-danger">Lưu ý: Hành động này không thể hoàn tác</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="deleteAccount()">Xác nhận</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Account Modal-->
<div class="modal fade" id="editAccountModal" tabindex="-1" role="dialog" aria-labelledby="editAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editAccountModalLabel">Sửa tài khoản: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="editModalBody">
                <form>
                    <div class="form-group">
                        <label>Nhập vào tên đăng nhập: </label>
                        <input class="form-control" placeholder="Tên đăng nhập" id="editedUserName">
                    </div>
                    <div class="form-group">
                        <label>Tên đầy đủ của tài khoản: </label>
                        <input class="form-control" placeholder="Tên đầy đủ" id="editedUserFullName">
                    </div>
                    <div class="form-group" id="currentUserPasswordChange">
                        <label>Nhập vào mật khẩu hiện tại: </label>
                        <input class="form-control" placeholder="Nhập vào mật khẩu hiện tại" type="password" id="originalUserPassword">
                    </div>
                    <div class="form-group">
                        <label>Nhập vào mật khẩu mới: </label>
                        <input class="form-control" type="password"  placeholder="Mật khẩu mới ( để nguyên nếu không muốn thay đổi )" id="editedUserPassword">
                
                    </div>
                    <div class="form-group" id="currentUserPasswordChange">
                        <label>Nhập lại mật khẩu mới: </label>
                        <input class="form-control" type="password" placeholder="Mật lại khẩu mới ( để nguyên nếu không muốn thay đổi )" id="editedUserPasswordConfrim">
                    </div>

        
                    <label>Hình ảnh của tài khoản: </label>
                    <input class="form-control-file" type="file" id="editedUserImage">
               


                    <div class="form-group">
                        <label>Giới tính:</label>
                        <select class="form-control" id="editedUserGender">
                            <option value="0">Nam</option>
                            <option value="1">Nữ</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Quyền:</label>
                        <select class="form-control" id="editedUserPermission">
                            <option value="0">Admin</option>
                            <option value="1">Nhân viên</option>
                            <option value="2">Nhà bếp</option>
                        </select>
                    </div>
                </form>    
       
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="editAccount()" id="buttonEditAccount">Sửa tài khoản</button>
            </div>
        </div>
    </div>
</div>

@section('content')
<div class="row">

    <div class="col-md-12">
        <div class="card ">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">Tài khoản của bạn</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>STT</th>
                                <th>Hình ảnh</th>
                                <th>Tên đăng nhập</th>
                                <th>Tên đầy đủ</th>
                                <th>Giới tính</th>
                                <th>Quyền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                            <tr>
                                <td><i class="material-icons">person</i></td>
                                <td>
                                    @if (trim(strlen($loggedUser->user_image)) != 0)
                                    <img style="width: 80px" src="{{$loggedUser->user_image}}">
                                    @endif
                                    
                                
                                </td>
                                <td>{{$loggedUser->user_name}}</td>
                                <td>{{$loggedUser->user_fullname}}</td>
                                <td>
                                    @if ($loggedUser->user_gender == 0)
                                        Nam
                                    @else
                                        Nữ
                                    @endif
                                </td>
                                <td>
                                 
                                    @switch($loggedUser->user_permission)
                                        @case(0)
                                            Admin
                                            @break
                                        @case(1)
                                            Nhân viên
                                        @break  
                                        @case(2)
                                            Nhà bếp
                                        @break     
                                    @endswitch

                                </td>
                                <td>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal" data-userid="{{$loggedUser->user_id}}" data-username="{{$loggedUser->user_name}}" onclick="deleteAccountModal(this)">Xóa</button>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#editAccountModal" data-userid="{{$loggedUser->user_id}}" data-username="{{$loggedUser->user_name}}" data-userfullname="{{$loggedUser->user_fullname}}" data-usergender="{{$loggedUser->user_gender}}" data-userpermission="{{$loggedUser->user_permission}}" onclick="editAccountModal(this)">Sửa</button>
                                </td>
                            </tr>
                  



                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card ">
            <div class="card-header card-header-primary">
                <h4 class="card-title ">Quản lý tài khoản</h4>
                <button class="btn btn-info" data-toggle="modal" data-target="#addAccountModal"><i class="material-icons">add</i>Tạo tài khoản mới</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>STT</th>
                                <th>Hình ảnh</th>
                                <th>Tên đăng nhập</th>
                                <th>Tên đầy đủ</th>
                                <th>Giới tính</th>
                                <th>Quyền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                            @if ($user->user_id != session()->get('user_id'))
                            <tr>
                                <td>{{$index}}</td>
                                <td>
                                    @if (trim(strlen($user->user_image)) != 0)
                                    <img style="width: 80px" src="{{$user->user_image}}">
                                    @endif
                                    
                                
                                </td>
                                <td>{{$user->user_name}}</td>
                                <td>{{$user->user_fullname}}</td>
                                <td>
                                    @if ($user->user_gender == 0)
                                        Nam
                                    @else
                                        Nữ
                                    @endif
                                </td>
                                <td>
                                 
                                    @switch($user->user_permission)
                                        @case(0)
                                            Admin
                                            @break
                                        @case(1)
                                            Nhân viên
                                        @break  
                                        @case(2)
                                            Nhà bếp
                                        @break     
                                    @endswitch

                                </td>
                                <td>
                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteAccountModal" data-userid="{{$user->user_id}}" data-username="{{$user->user_name}}" onclick="deleteAccountModal(this)">Xóa</button>
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#editAccountModal" data-userid="{{$user->user_id}}" data-username="{{$user->user_name}}" data-userfullname="{{$user->user_fullname}}" data-usergender="{{$user->user_gender}}" data-userpermission="{{$user->user_permission}}" onclick="editAccountModal(this)">Sửa</button>
                                </td>
                            </tr>                                
                            @endif
                 
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
        var editModalHTML;
        $(document).ready(function() {
            storeEditModalHTML();
        });

        function storeEditModalHTML(){
            editModalHTML = $('#editModalBody').html();
        }

        var loggedUserID = {{Session::get('user_id')}};
        var currentUserID;
        function addAccount(){
            var formData = new FormData();
            var imageFile = $("#newUserImage")[0].files[0];
            if ($("#newUserImage").val()){
                formData.append('imgInp', imageFile);
            }
            formData.append('newUserName',$('#newUserName').val());
            formData.append('newUserFullName',$('#newUserFullName').val());
            formData.append('newUserPermission' , $('#newUserPermission').val());
            formData.append('newUserGender' , $('#newUserGender').val());
            formData.append('newUserPassword' , $('#newUserPassword').val())
            formData.append('_token', CSRF_TOKEN);
            $.ajax({
                url: '{{ route('addAccount') }}',
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

        function deleteAccountModal(evt){
            currentUserID = $(evt).data("userid");
            if (currentUserID == loggedUserID){
                $('#confrimDeleteText').html("Lưu ý: Đây là tài khoản của bạn!! Bạn có chắc chắn muốn xóa tài khoản không?")
            }
            else {
                $('#confrimDeleteText').html("Bạn có chắc chắn muốn xóa tài khoản: <span style='font-weight: 700'>" + $(evt).data("username") + "</span> không?")
            }
           
            
        }

        function deleteAccount(){
            $.ajax({
                url: '{{ route('deleteAccount') }}',
                type: 'POST',
                data: {_token: CSRF_TOKEN , userID: currentUserID},
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

        function editAccountModal(evt){
            $('[id=currentUserPasswordChange]').hide();
            currentUserID = $(evt).data('userid')
            $('#editAccountModalLabel').html("Sửa tài khoản: " + $(evt).data('username'));
            $('#editedUserName').val($(evt).data('username'));
            $('#editedUserFullName').val($(evt).data('userfullname'));
            $('#editedUserGender').val($(evt).data('usergender')).change();
            $('#editedUserPermission').val($(evt).data('userpermission')).change();

            if (loggedUserID == currentUserID){
                $('[id=currentUserPasswordChange]').show();
            }
        }

        function editAccount(){
            var formData = new FormData();
            var imageFile = $("#editedUserImage")[0].files[0];
            if ($("#editedUserImage").val()){
                formData.append('imgInp', imageFile);
            }

            if (loggedUserID == currentUserID) {
                formData.append('editedUserPassword', $('#editedUserPassword').val());
                formData.append('editedUserPasswordConfrim', $('#editedUserPasswordConfrim').val());
                formData.append('originalUserPassword' , $('#originalUserPassword').val());
            }
            formData.append('editedUserID',currentUserID);
            formData.append('editedUserName',$('#editedUserName').val());
            formData.append('editedUserFullName',$('#editedUserFullName').val());
            formData.append('editedUserPermission' , $('#editedUserPermission').val());
            formData.append('editedUserGender' , $('#editedUserGender').val());
            formData.append('editedUserPassword' , $('#editedUserPassword').val())
            formData.append('_token', CSRF_TOKEN);
            $.ajax({
                url: '{{ route('editAccount') }}',
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
    </script>
@endsection


