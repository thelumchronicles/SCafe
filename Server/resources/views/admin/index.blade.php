@extends('admin/layout/layout1' , ['title' => "Trang tổng quan"])

@section('content')
<div class="row">
  <div class="col-lg-3 col-md-6 col-sm-6">
    <div class="card card-stats">
      <div class="card-header card-header-success card-header-icon">
        <div class="card-icon">
          <i class="material-icons">content_copy</i>
        </div>
        <p class="card-category">Tổng doanh thu</p>
        <h3 class="card-title">{{number_format($totalRevenue, 0, '', ',')}}
          <small>VNĐ</small>
        </h3>
      </div>
      <div class="card-footer">
        <div class="stats">
   
        </div>
      </div>
    </div>
  </div>



    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-info card-header-icon">
          <div class="card-icon">
            <i class="material-icons">content_copy</i>
          </div>
          <p class="card-category">Số bàn đang được đặt</p>
          <h3 class="card-title">{{$inOrderTable}}
            <small>bàn</small>
          </h3>
        </div>
        <div class="card-footer">
          <div class="stats">
     
          </div>
        </div>
      </div>
    </div>

    
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="card card-stats">
        <div class="card-header card-header-warning card-header-icon">
          <div class="card-icon">
            <i class="material-icons">store</i>
          </div>
          <p class="card-category">Doanh thu chưa thanh toán</p>
          <h3 class="card-title">{{number_format($haventFinishedIncome, 0, '', ',')}}VNĐ</h3>
       
        </div>
        <div class="card-footer">
            <div class="stats">
       
            </div>
          </div>
      </div>
    </div>
    

  </div>
@endsection