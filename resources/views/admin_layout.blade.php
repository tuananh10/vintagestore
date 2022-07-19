<!DOCTYPE html>
<head>
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}" >
<meta name="csrf-token" content="{{csrf_token()}}">
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('backend/css/font.css')}}" type="text/css"/>
<link href="{{asset('backend/css/font-awesome.css')}}" rel="stylesheet"> 
<link rel="stylesheet" href="{{asset('backend/css/morris.css')}}" type="text/css"/>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<!-- calendar -->
<link rel="stylesheet" href="{{asset('backend/css/monthly.css')}}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<!-- //calendar -->
<!-- //font-awesome icons -->
<script src="{{asset('backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('backend/js/raphael-min.js')}}"></script>
<script src="{{asset('backend/js/morris.js')}}"></script>
</head>
<body>
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="/dashboard" class="logo">
        TA Store
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="{{asset('backend/images/2.png')}}">
                <span class="username">
                    @php
                    $name = Session::get('admin_name');
                    if($name){
                        echo $name; 
                    }
                    @endphp
                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                <li><a href="{{URL::to('/logout')}}"><i class="fa fa-key"></i> Đăng Xuất </a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('/dashboard')}}">
                        <i class="fa fa-dashboard"></i>
                        <span>Tổng quan</span>
                    </a>
                </li>
                <li>
                    <a href="{{URL::to('/information')}}">
                        <i class="icon icon-info-sign"></i>
                        <span>Thông tin liên hệ</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Banner</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-slider')}}">Thêm Slider</a></li>
						<li><a href="{{URL::to('/manage-slider')}}">Liệt kê Slider</a></li>
                    </ul>
                </li> 
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Đơn hàng</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/manage-order')}}">Quản lý đơn hàng</a></li>
                    </ul>
                </li> 
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Mã giảm giá</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/insert-coupon')}}">Quản lý mã giảm giá</a></li>
						<li><a href="{{URL::to('/list-coupon')}}">Liệt kê mã giảm giá</a></li>
                    </ul>
                </li> 
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Vận chuyển</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/delivery')}}">Quản lý vận chuyển</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Danh mục sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-category-product')}}">Thêm danh mục</a></li>
						<li><a href="{{URL::to('/all-category-product')}}">Liệt kê danh mục</a></li>
                    </ul>
                </li> 
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Thương hiệu sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-brand-product')}}">Thêm thương hiệu sản phẩm</a></li>
						<li><a href="{{URL::to('/all-brand-product')}}">Liệt kê thương hiệu sản phẩm</a></li>
                    </ul>
                </li>  
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('/add-product')}}">Thêm sản phẩm</a></li>
						<li><a href="{{URL::to('/all-product')}}">Liệt kê sản phẩm</a></li>
                    </ul>
                </li>                      
            </ul>            
        </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
        @yield('admin_content')
    </section>
 <!-- footer -->
		  <div class="footer">
			<div class="wthree-copyright">
			  <p>© 2022 Visitors. All rights reserved | Design by <a href="http://w3layouts.com">TuanAnhStore</a></p>
			</div>
		  </div>
  <!-- / footer -->
</section>
<!--main content end-->
</section>
<script src="{{asset('backend/js/bootstrap.js')}}"></script>
<script src="{{asset('backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('backend/js/scripts.js')}}"></script>
<script src="{{asset('backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('backend/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('backend/js/simple.money.format.js')}}"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>

<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('backend/js/jquery.scrollTo.js')}}"></script>
<!-- morris JavaScript -->	

<script type="text/javascript">
    CKEDITOR.replace( 'info_contact' );
</script>
<!-- Format Money  -->	
{{-- <script type="text/javascript">
    $('.price_format').simpleMoneyFormat();
</script> --}}
<!-- Nút lọc kết quả -->	
{{-- <script type="text/javascript">
    $(document).ready(function(){
        chart60daysorder();
        var chart = new Morris.Bar({
            element: 'chart',
            lineColors: ['#819C79','#fc8710','#FF6541','#A4ADD3','#766B56'],
            barColors: ["#B21516", "#1531B2", "#1AB244", "#B29215",'#766B56'],
            pointFillColors: ['#ffffff'],
            pointStockColors: ['black'],
            fillOpacity:0.6,
            hideHover:'auto',
            parseTime:false,

            xkey:'period',
            ykeys: ['order','sales','profit','quantity'],
            behaveLikeLine:true,
            labels:['đơn hàng','doanh số','lợi nhuận','số lượng']
        });

        function chart60daysorder(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:'{{url('/days-order')}}',
                method:"POST",
                dataType:"JSON",
                data:{_token:_token},
                success:function(data){
                    chart.setData(data);
                }
            });
        }

        $('.dashboard-filter').change(function(){
            var dashboard_value = $(this).val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:'{{url('/dashboard-filter')}}',
                method:"POST",
                dataType:"JSON",
                data:{_token:_token,dashboard_value:dashboard_value},
                success:function(data){
                    chart.setData(data);
                }
            });
        });

        $('#btn-dashboard-filter').click(function(){
            var _token = $('input[name="_token"]').val();
            var from_date = $('#datepicker').val();
            var to_date = $('#datepicker2').val();
            $.ajax({
                url:'{{url('/filter-by-date')}}',
                method:"POST",
                dataType:"JSON",
                data:{_token:_token,from_date:from_date,to_date:to_date },
                success:function(data){
                    chart.setData(data);
                }
            });
        });
    });
</script> --}}

<!-- Datepicker -->	
<script type="text/javascript">
    $(function(){
        $("#datepicker").datepicker({
            prevText:"Tháng trước",
            nextText:"Tháng sau",
            dateFormat:"yy-mm-dd",
            duration: "fast"
        });
    });
    $(function(){
        $("#datepicker2").datepicker({
            prevText:"Tháng trước",
            nextText:"Tháng sau",
            dateFormat:"yy-mm-dd",
            duration: "fast"
        });
    });
</script>
<!-- Thư viện ảnh -->	
<script type="text/javascript">
    $(document).ready(function(){
        load_gallery();
        function load_gallery(){
            var prod_id = $('.prod_id').val();
            var _token = $('input[name="_token"]').val();
            // alert(prod_id); 
            $.ajax({
                url: '{{url('/select-gallery')}}',
                method: 'POST',
                data: {prod_id:prod_id,
                _token:_token},
                success:function(data){
                    $('#gallery_load').html(data);
                }

            });
        }

        //lỗi ảnh
        $('#file').change(function(){
            var error = '';
            var files = $('#file')[0].files;

            if(files.length>5){
                error+='<p>Bạn chỉ được chọn tối đa 5 ảnh</p>';
            }
            // else if(files.length==''){
            //     error+='<p>Bạn không được bỏ trống ảnh</p>';
            // }else if(files.size > 2000000){
            //     error+='<p>File ảnh vượt quá 2MB</p>';
            // }

            if(error==''){
            }else{
                $('#file').val('');
                $('#error_gallery').html('<span class="text-danger">'+error+'</span>');
                return false;
            }
        });

        //Sửa tên ảnh
        $(document).on('blur','.edit_gal_name',function(){
            var gal_id = $(this).data('gal_id');
            var gal_text = $(this).text();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{url('/update-gallery-name')}}',
                method: 'POST',
                data: {gal_id:gal_id,
                gal_text:gal_text,
                _token:_token},
                success:function(data){
                    load_gallery();
                    $('#error_gallery').html('<span class="text-success">Cập nhật tên hình ảnh thành công</span>');
                }

            });
        });

        //Xóa ảnh
        $(document).on('click','.delete-gallery',function(){
            var gal_id = $(this).data('gal_id');
            var _token = $('input[name="_token"]').val();
            if(confirm('Bạn có muốn xóa hình ảnh này không')){
            $.ajax({
                url: '{{url('/delete-gallery')}}',
                method: 'POST',
                data: {gal_id:gal_id,
                _token:_token},
                success:function(data){
                    load_gallery();
                    $('#error_gallery').html('<span class="text-success">Cập nhật tên hình ảnh thành công</span>');
                }
            });
        }
        });

        //thay hình ảnh
        $(document).on('change','.file_image',function(){
            var gal_id = $(this).data('gal_id');
            var image = document.getElementById('file-'+gal_id).files[0];

            var form_data = new FormData();

            form_data.append("file",document.getElementById('file-'+gal_id).files[0]);
            form_data.append("gal_id",gal_id);
            
            $.ajax({
                url: '{{url('/update-gallery')}}',
                method: 'POST',
                headers:{
                    'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                },
                data:form_data,
                contentType:false,
                cache:false,
                processData:false,
                success:function(data){
                    load_gallery();
                    $('#error_gallery').html('<span class="text-success">Cập nhật hình ảnh thành công</span>');
                }
            });
        
        });
    });
</script>

<!-- Cập nhật số lượng đặt hàng -->	
<script type="text/javascript">
    $('.update_quantity_order').click(function(){
        var order_product_id = $(this).data('product_id');
        var order_qty = $('.order_qty_'+order_product_id).val();
        var order_code = $('.order_code').val();
        var _token = $('input[name="_token"]').val();

        $.ajax({
            url : '{{url('/update-qty')}}',
            method: 'POST',
            data:{_token:_token, 
            order_product_id:order_product_id,
            order_qty:order_qty,
            order_code:order_code},
            success:function(data){
                alert('Cập nhật số lượng thành công');
                location.reload();
            }
        });
    });
</script>

<!--Chi tiết đơn hàng-->	
<script type="text/javascript">
    $('.order_details').change(function(){
        var order_status = $(this).val();
        var order_id = $(this).children(":selected").attr("id");
        var _token = $('input[name="_token"]').val();

        //lấy ra số lượng
        quantity = [];
        $("input[name='product_sales_quantity']").each(function(){
            quantity.push($(this).val());
        });
        //lấy ra product_id
        order_product_id = [];
        $("input[name='order_product_id']").each(function(){
            order_product_id.push($(this).val());
        });
        j = 0;
        for(i=0;i<order_product_id.length;i++){
            //so luong khach dat
            var order_qty = $('.order_qty_' + order_product_id[i]).val();
            //so luong ton kho
            var order_qty_storage = $('.order_qty_storage_' + order_product_id[i]).val();

            if(parseInt(order_qty)>parseInt(order_qty_storage)){
                j = j + 1;
                if(j==1){
                    alert('Số lượng bán trong kho không đủ');
                }
                $('.color_qty_'+order_product_id[i]).css('background','#000');
            }
        }
        if(j==0){
          
                $.ajax({
                    url : '{{url('/update-order-qty')}}',
                    method: 'POST',
                    data:{_token:_token, order_status:order_status ,order_id:order_id ,quantity:quantity, order_product_id:order_product_id},
                    success:function(data){
                        alert('Thay đổi tình trạng đơn hàng thành công');
                        location.reload();
                }
            });      
        }
    });
</script>


<!-- Lựa chọn địa chỉ đặt hàng để tính phí -->	
<script type="text/javascript">
    $(document).ready(function(){

        fetch_delivery();

        function fetch_delivery(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url : '{{url('/select-feeship')}}',
                method: 'POST',
                data:{_token:_token},
                success:function(data){
                    $('#load_delivery').html(data);
                }
            });
        }
        //update sửa tiền phí trực tiếp
        $(document).on('blur','.fee_feeship_edit',function(){
            var feeship_id = $(this).data('feeship_id');
            var fee_value = $(this).text();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url : '{{url('/update-delivery')}}',
                method: 'POST',
                data:{feeship_id:feeship_id,fee_value:fee_value,_token:_token},
                success:function(data){
                    fetch_delivery();;
                }
            });

        });

        $('.add_delivery').click(function(){
            var city = $('.city').val();
            var province = $('.province').val();
            var ward = $('.ward').val();
            var fee_ship = $('.fee_ship').val();
            var _token = $('input[name="_token"]').val();
            
            $.ajax({
                url : '{{url('/insert-delivery')}}',
                method: 'POST',
                data:{city:city,province:province,ward:ward,fee_ship:fee_ship,_token:_token},
                success:function(data){
                    fetch_delivery();;
                }
            });
        });
        $('.choose').on('change',function(){
            var action = $(this).attr('id');
            var ma_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            var result = '';
            if(action == 'city'){
                result = 'province';
            }else{
                result = 'ward';
            }
            $.ajax({
                url : '{{url('/select-delivery')}}',
                method: 'POST',
                data:{action:action,ma_id:ma_id,_token:_token},
                success:function(data){
                    // nếu chọn city thì biến province sẽ đặt vào id(#)
                    $('#'+result).html(data);
                }
            });
        });
    });
</script>

<!-- morris Donut Chart -->	
<script type="text/javascript">
    $(document).ready(function(){
        var donut = Morris.Donut({
            element: 'donut',
            resize: true,
            colors: ['#ce616a','#61a1ce','#ce8f61','#f5b942','#4842f5'],
            data: [
                {label:"Sản phẩm", value:<?php echo $app_product ?>},
                {label:"Đơn hàng", value:<?php echo $app_order ?>},
                {label:"Khách hàng", value:<?php echo $app_customer ?>}
            ]
        });
    });
</script>   

</body>
</html>
