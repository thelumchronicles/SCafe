<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/jqueryPrint.js') }}"></script>

    </head>

<style>
    @import url('https://fonts.googleapis.com/css?family=Roboto');

    body {
        font-family: 'Roboto', sans-serif;
    }

    * {
        margin: 0;
        padding: 0;
    }

    i {
        margin-right: 10px;
    }

    /*----------multi-level-accordian-menu------------*/
    .navbar-logo {
        padding: 15px;
        color: #fff;
    }

    .navbar-mainbg {
        background-color: #9c27b0;
        padding: 0px;
    }

    #navbarSupportedContent {
        overflow: hidden;
        position: relative;
    }

    #navbarSupportedContent ul {
        padding: 0px;
        margin: 0px;
    }

    #navbarSupportedContent ul li a i {
        margin-right: 10px;
    }

    #navbarSupportedContent li {
        list-style-type: none;
        float: left;
    }

    #navbarSupportedContent ul li a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        font-size: 15px;
        display: block;
        padding: 20px 20px;
        transition-duration: 0.6s;
        transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
        position: relative;
    }

    #navbarSupportedContent>ul>li.active>a {
        color: #9c27b0;
        background-color: transparent;
        transition: all 0.7s;
    }

    #navbarSupportedContent a:not(:only-child):after {
        content: "\f105";
        position: absolute;
        right: 20px;
        top: 10px;
        font-size: 14px;
        font-family: "Font Awesome 5 Free";
        display: inline-block;
        padding-right: 3px;
        vertical-align: middle;
        font-weight: 900;
        transition: 0.5s;
    }

    #navbarSupportedContent .active>a:not(:only-child):after {
        transform: rotate(90deg);
    }

    .hori-selector {
        display: inline-block;
        position: absolute;
        height: 100%;
        top: 0px;
        left: 0px;
        transition-duration: 0.6s;
        transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
        background-color: #fff;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        margin-top: 10px;
    }

    .hori-selector .right,
    .hori-selector .left {
        position: absolute;
        width: 25px;
        height: 25px;
        background-color: #fff;
        bottom: 10px;
    }

    .hori-selector .right {
        right: -25px;
    }

    .hori-selector .left {
        left: -25px;
    }

    .hori-selector .right:before,
    .hori-selector .left:before {
        content: '';
        position: absolute;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: #9c27b0;
    }

    .hori-selector .right:before {
        bottom: 0;
        right: -25px;
    }

    .hori-selector .left:before {
        bottom: 0;
        left: -25px;
    }


    @media(min-width: 992px) {
        .navbar-expand-custom {
            -ms-flex-flow: row nowrap;
            flex-flow: row nowrap;
            -ms-flex-pack: start;
            justify-content: flex-start;
        }

        .navbar-expand-custom .navbar-nav {
            -ms-flex-direction: row;
            flex-direction: row;
        }

        .navbar-expand-custom .navbar-toggler {
            display: none;
        }

        .navbar-expand-custom .navbar-collapse {
            display: -ms-flexbox !important;
            display: flex !important;
            -ms-flex-preferred-size: auto;
            flex-basis: auto;
        }
    }


    @media (max-width: 991px) {
        #navbarSupportedContent ul li a {
            padding: 12px 30px;
        }

        .hori-selector {
            margin-top: 0px;
            margin-left: 10px;
            border-radius: 0;
            border-top-left-radius: 25px;
            border-bottom-left-radius: 25px;
        }

        .hori-selector .left,
        .hori-selector .right {
            right: 10px;
        }

        .hori-selector .left {
            top: -25px;
            left: auto;
        }

        .hori-selector .right {
            bottom: -25px;
        }

        .hori-selector .left:before {
            left: -25px;
            top: -25px;
        }

        .hori-selector .right:before {
            bottom: -25px;
            left: -25px;
        }
    }


   
    .setting-item a{
        
        color: white !important;
    }

    /*searchbox*/

		.custom_search{
			color: #FFF !important;
			background: transparent;
			border: 0;
			border-radius: 0;
			border-bottom: 2px solid #FFF;
			width: 240px !important;
		}
		.custom_search:focus{
			box-shadow: none;
			background: transparent;
			border-bottom:2px solid #FFF;
		}
		.custom_search::placeholder{
			color: #FFF !important;
		}


        .product-category-picker {
            padding-top: 20px;
            
            padding-left: 50px;
            padding-right: 50px;
        }
        .product-card {

            padding: 20px;
        }

        .table-status {
            color: white;
            font-size: 18px;
            font-weight: 700;
        }
        .product-img-wrapper {
            position: relative;
            text-align: center;
        }

        .product-img-wrapper .centered {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }


        .product-card img {
        
            width: 150px;   
        }

        .tableBackgroundImage {
            height: 84px;
            width: 150px;   
        }
        .price {
            font-weight: 700;
            color: #9c27b0;
        }

        .product-wrapper {
            padding: 30px;
        }
        .product-card {
            display: inline-block;
        }

        .product-card:hover {
            -moz-box-shadow:    3px 3px 5px 3px #ccc;
            -webkit-box-shadow: 3px 3px 5px 3px #ccc;
            box-shadow:         3px 3px 5px 3px #ccc;
        }

        .product-category-picker {
            margin-top: 10px;
        }

        .btn-primary {
            background: #9c27b0;
        }

        .btn-primary:focus {
            background: #9c27b0;
        }

        .btn-primary:hover {
            background: #9c27b0;
        }

        .ammoutInput {
            width: 50px;
        }

        .decreaseVal {

            width: 30px;
        }
        .increaseVal {
            width: 30px;
        }

        .invoice-header {
            border-radius: 25px;
            padding: 10px;
            color: white;
            background: -webkit-linear-gradient(left, #a445b2, #d41872, #fa4299);
            font-weight: 700;
        }

        .room-header {
            margin-right: 10px;
            border-radius: 25px;
            padding: 10px;
            color: white;
            background-color: #ee8c68;
            background-image: linear-gradient(315deg, #ee8c68 0%, #eb6b9d 74%);
            font-weight: 700;
        }

        .menu-header {
            margin-top: 30px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

</style>

<body>

    @include('employee/partials/navbar')

<!-- Modal -->
    <div class="modal fade" id="userSettingModal" tabindex="-1" role="dialog" aria-labelledby="userSettingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="userSettingModalLabel">Cài đặt tài khoản</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <label>Hình ảnh của tài khoản: </label>
            <img src="{{session()->get('user_image')}}" style="width: 80px">
            <br>
            <label>Tên đăng nhập</label>
            <input class="form-control" value="{{session()->get('user_name')}}" disabled>
            <label>Tên nhân viên</label>
            <input class="form-control" value="{{session()->get('user_fullname')}}" disabled>
            <label>Giới tính</label>
            <input class="form-control" value="{{session()->get('user_gender')}}" disabled>
            <label>Mật khẩu cũ</label>
            <input class="form-control" type="password" id="oldPassword">
            <label>Mật khẩu mới</label>
            <input class="form-control" type="password" id="newPassword">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="changePassword()">Lưu</button>
            </div>
        </div>
        </div>
    </div>

    
    <div class="row no-gutters">
  
        <div class="col-6">
            @yield('chonThucDon')

        </div>
        <div class="col-6">
            @yield('thucDonDaChon')
        </div>
    </div>
</body>

<script>
    function printInvoice(){
        var mywindow = window.open('', 'PRINT');

        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h1>' + document.title  + '</h1>');
        mywindow.document.write(document.getElementById("payModalBody").innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    }
    function changePassword(){
        var oldPassword = $('#oldPassword').val();
        var newPassword = $('#newPassword').val();
        $.ajax({
            method:"POST",    
            url:"{{ route('changePassword') }}",
            data:{oldPassword:oldPassword , newPassword:newPassword , _token:CSRF_TOKEN},
            success:function(data){ 
                if(data == "Success") {
                    alert("Thay đổi mật khẩu thành công");
                }
                else {
                    alert(data);
                }
            }
        });   
    }
</script>

<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    // ---------Responsive-navbar-active-animation-----------
    function test() {
        var tabsNewAnim = $('#navbarSupportedContent');
        var selectorNewAnim = $('#navbarSupportedContent').find('li').length;
        var activeItemNewAnim = tabsNewAnim.find('.active');
        var activeWidthNewAnimHeight = activeItemNewAnim.innerHeight();
        var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
        var itemPosNewAnimTop = activeItemNewAnim.position();
        var itemPosNewAnimLeft = activeItemNewAnim.position();
        $(".hori-selector").css({
            "top": itemPosNewAnimTop.top + "px",
            "left": itemPosNewAnimLeft.left + "px",
            "height": activeWidthNewAnimHeight + "px",
            "width": activeWidthNewAnimWidth + "px"
        });
        $("#navbarSupportedContent").on("click", "li", function (e) {
            if (!$(this).hasClass('setting-item')){
                $('#navbarSupportedContent ul li').removeClass("active");
                $(this).addClass('active');
                var activeWidthNewAnimHeight = $(this).innerHeight();
                var activeWidthNewAnimWidth = $(this).innerWidth();
                var itemPosNewAnimTop = $(this).position();
                var itemPosNewAnimLeft = $(this).position();
                $(".hori-selector").css({
                    "top": itemPosNewAnimTop.top + "px",
                    "left": itemPosNewAnimLeft.left + "px",
                    "height": activeWidthNewAnimHeight + "px",
                    "width": activeWidthNewAnimWidth + "px"
                });
            }

        });
    }
    $(document).ready(function () {
        setTimeout(function () { test(); });
    });
    $(window).on('resize', function () {
        setTimeout(function () { test(); }, 500);
    });
    $(".navbar-toggler").click(function () {
        setTimeout(function () { test(); });
    });
</script>

@yield('scripts')

</html>