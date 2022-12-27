@extends('admin/layout/layout2' , ['title' => "Chi tiết phòng bàn"])

@section('content')



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
                <li class="nav-item active">
                    <a class="nav-link" href="javascript:void(0);"><i class="fa fa-table"></i>Phòng bàn</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="javascript:void(0);"><i class="fa fa-cutlery"></i>Thực đơn</a>
                </li>
            
                <form class="form-inline my-2 my-lg-0 col-md-4 ">
                    <div style="position: relative;">
                          <input class="custom_search form-control mr-sm-2" type="search" placeholder="Tìm mặt hàng" aria-label="Search">
                          <span class="search_span"></span>
                      </div>
                  
                </form>
      
            </ul>

         

            <ul class="navbar-nav ml-auto" style="color: white !important">
                <li class="nav-item setting-item notification-nav">
                    <a href="#"><i class="fa fa-bell"></i> Thông báo (0)</a>
                </li>

                <li class="nav-item setting-item">
                    <a href="#"><i class="fa fa-cog"></i> Phan Văn Quốc Tuấn</a>
                </li>
                <li class="nav-item setting-item">
                    <a href="{{ route('logout') }}"><i class="fa fa-sign-out"></i> Đăng xuất</a>
                </li>
      
            </ul>

     
        </div>
    </nav>


    <div class="row no-gutters">
  
        <div class="col-6">
            <div class="product-category-picker">
                <button class="btn btn-primary">Tất cả</button>
                <button class="btn btn-light">Tất cả</button>
                <button class="btn btn-light">Bida</button>
                <button class="btn btn-light">Cafe</button>
                <button class="btn btn-light">Cơm Trưa</button>
                <button class="btn btn-light">Hải Sản</button>
            </div>
            <div class="product-wrapper">
                <div class="product-card">
                    <img src="https://cafefcdn.com/thumb_w/650/2020/6/14/hinh-anh-ly-cafe-buoi-sang-dep-hinhminhhoa-1592099048025598964586-crop-1592099057052994975563.jpg">
                    <div>Cafe sữa đá</div>
                    <span class="price">14.000</span>
                </div>
                <div class="product-card">
                    <img src="https://cafefcdn.com/thumb_w/650/2020/6/14/hinh-anh-ly-cafe-buoi-sang-dep-hinhminhhoa-1592099048025598964586-crop-1592099057052994975563.jpg">
                    <div>Cafe sữa đá</div>
                    <span class="price">14.000</span>
                </div>
                <div class="product-card">
                    <img src="https://cafefcdn.com/thumb_w/650/2020/6/14/hinh-anh-ly-cafe-buoi-sang-dep-hinhminhhoa-1592099048025598964586-crop-1592099057052994975563.jpg">
                    <div>Cafe sữa đá</div>
                    <span class="price">14.000</span>
                </div>
                <div class="product-card">
                    <img src="https://cafefcdn.com/thumb_w/650/2020/6/14/hinh-anh-ly-cafe-buoi-sang-dep-hinhminhhoa-1592099048025598964586-crop-1592099057052994975563.jpg">
                    <div>Cafe sữa đá</div>
                    <span class="price">14.000</span>
                </div>
                <div class="product-card">
                    <img src="https://cafefcdn.com/thumb_w/650/2020/6/14/hinh-anh-ly-cafe-buoi-sang-dep-hinhminhhoa-1592099048025598964586-crop-1592099057052994975563.jpg">
                    <div>Cafe sữa đá</div>
                    <span class="price">14.000</span>
                </div>
                <div class="product-card">
                    <img src="https://cafefcdn.com/thumb_w/650/2020/6/14/hinh-anh-ly-cafe-buoi-sang-dep-hinhminhhoa-1592099048025598964586-crop-1592099057052994975563.jpg">
                    <div>Cafe sữa đá</div>
                    <span class="price">14.000</span>
                </div>
            </div>

        </div>
        <div class="col-6">
            <span class="room-header">Lầu 2 - Phòng 1</span><span class="invoice-header">phong 2 - DTH00001</span>
            <button class="btn btn-danger"><i class="fa fa-times-circle" aria-hidden="true"></i>Hủy thực đơn</button>

           
            




            <div class="row">

                <div class="col-12">
                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Danh mục của món ăn</h4>
                            <button class="btn btn-success"><i class="fa fa-money" aria-hidden="true"></i>Thanh toán</button>
                            <button class="btn btn-danger"><i class="fa fa-bullhorn" aria-hidden="true"></i>Thông báo cho nhà bếp</button>
                            <button class="btn btn-info"><i class="fa fa-arrows" aria-hidden="true"></i>Chuyển ghép bàn</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
            
                                    <tbody>
                                        <tr>
                                          <th scope="row">1</th>
                                          <td>Trà Gừng</td>
                                          <td>
                                              <input type="button" value="-" class="decreaseVal">
                                              <input class="ammoutInput">
                                              <input type="button" value="+" class="increaseVal">
                                          </td>
                                          <td>@14000</td>
                                          <td>14000</td>
                                          <td><button class="btn btn-danger">x</td>
                                        </tr>
                                        <tr>
                                          <th scope="row">2</th>
                                          <td>Trà Gừng</td>
                                          <td>
                                              <input type="button" value="-" class="decreaseVal">
                                              <input class="ammoutInput">
                                              <input type="button" value="+" class="increaseVal">
                                          </td>
                                          <td>@14000</td>
                                          <td>14000</td>
                                          <td><button class="btn btn-danger">x</button></td>
                                        </tr>
                                      </tbody>
                                </table>
                            </div>
                            <label for="cars">Chọn mã giảm giá: </label>

                            <select name="cars" id="cars" style="padding: 10px">
                                <option value="volvo">Không có mã</option>
                              <option value="volvo">Mã giảm -5%</option>
                              <option value="saab">VALUNGTUNG - Mã giảm ngày valentine - 10%</option>
                              <option value="mercedes">NHANVIEN10 - Mã giảm cho nhân viên -10%</option>
                            </select>
                            <h4 style="margin-top: 20px;"><i class="fa fa-terminal" aria-hidden="true"></i>Mã giảm giá: Không có</h4>
                            <h4><i class="fa fa-percent" aria-hidden="true"></i>Phần trăm giảm giá: 0%</h4>
                            <h4><i class="fa fa-gift" aria-hidden="true"></i>Số tiền được giảm: 0VNĐ</h4>
                            <h1><i class="fa fa-money" aria-hidden="true"></i>Tổng tiền: 105.000VNĐ</h1>
                        </div>
                    </div>
                </div>
            
            </div>
        </div>
    </div>

@endsection

