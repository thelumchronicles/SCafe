<div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item {{ Request::routeIs('adminIndex') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('adminIndex') }}">
          <i class="material-icons">dashboard</i>
          <p>Tổng quan</p>
        </a>
      </li>
      <li class="nav-item {{ Request::routeIs('foodCategory') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('foodCategory') }}">
          <i class="material-icons">person</i>
          <p>Quản lý thực đơn</p>
        </a>
      </li>
      <li class="nav-item {{ Request::routeIs('roomIndex') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('roomIndex') }}">
          <i class="material-icons">content_paste</i>
          <p>Quản lý phòng bàn</p>
        </a>
      </li>
      <li class="nav-item {{ Request::routeIs('chienDich') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('chienDich') }}">
          <i class="material-icons">bubble_chart</i>
          <p>Quản lý chiến dịch</p>
        </a>
      </li>
      <li class="nav-item {{ Request::routeIs('manageAccount') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('manageAccount') }}">
          <i class="material-icons">library_books</i>
          <p>Quản lý tài khoản</p>
        </a>
      </li>


      <li class="nav-item active-pro ">
        <a class="nav-link">
          <i class="material-icons">unarchive</i>
          <p>{{session()->get('user_name')}}</p>
        </a>
      </li>



    </ul>
  </div>