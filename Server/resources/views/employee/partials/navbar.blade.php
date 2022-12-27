<nav class="navbar navbar-expand-custom navbar-mainbg">
    <a class="navbar-brand navbar-logo" href="#">SCafe Employees</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
    </button>
    <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav " style="margin-left: 150px;">
            <div class="hori-selector">
                <div class="left"></div>
                <div class="right"></div>
            </div>
            @if (Request::routeIs('employeeIndex') || str_contains(url()->current(), '/phongban') || str_contains(url()->current() , "/filter"))
            <li class="nav-item active">
            @else 
            <li class="nav-item">
            @endif
                <a class="nav-link" href="{{ route('employeeIndex') }}"><i class="fa fa-table"></i>Phòng bàn</a>
            </li>
            @if(str_contains(url()->current(), '/thucdon'))
            <li class="nav-item active">
            @else 
            <li class="nav-item">
            @endif
                <a class="nav-link" href="{{ route('thucdon') }}"><i class="fa fa-cutlery"></i>Thực đơn</a>
            </li>
            <li class="nav-item setting-item" style="margin-left: 80px">
                <button type="button" style="margin-top: 10px" class="btn btn-primary" data-toggle="modal" data-target="#searchGlobalModal"><i class="fa fa-search"></i>Tìm mặt hàng</button>
            </li>
        </ul>

     

        <ul class="navbar-nav ml-auto" style="color: white !important">
            <li class="nav-item setting-item">
                <a data-toggle="modal" data-target="#userSettingModal"><i class="fa fa-cog"></i>{{session()->get('user_fullname')}}</a>
            </li>
            <li class="nav-item setting-item">
                <a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Đăng xuất</a>
            </li>
  
        </ul>

 
    </div>
</nav>