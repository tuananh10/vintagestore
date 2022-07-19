<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="">

    <meta name="author" content="">
    <title>Home | TA Store</title>
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/price-range.css')}}" rel="stylesheet">
    <link href="{{asset('frontend/css/animate.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/responsive.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/sweetalert.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/lightslider.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/lightgallery.min.css')}}" rel="stylesheet">
	<link href="{{asset('frontend/css/prettify.css')}}" rel="stylesheet">

    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head><!--/head-->

<body>
	{{-- @php
		echo Session::get('customer_id');
		echo Session::get('shipping_id');
	@endphp --}}
	<header id="header"><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +036 910 7698</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> tuananh10@gmail.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<div class="logo pull-left">
							<a href="/trang-chu"><img id="imglogo" src="{{asset('frontend/images/logo.png')}}" alt="" /></a>
						</div>
						<div class="btn-group pull-right">
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									VN
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">USA</a></li>
								</ul>
							</div>
							
							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
									VNĐ
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									<li><a href="#">USD</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-8" id="1">
						<div class="shop-menu pull-right">
							<ul class="nav navbar-nav">
								{{-- <li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-user"></i> Tài Khoản</a></li> --}}
								<?php
								$customer_id=Session::get('customer_id');
								$shipping_id=Session::get('shipping_id');
									if($customer_id!=Null && $shipping_id==Null){
								?>
									<li><a href="{{URL::to('/checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
									}elseif($customer_id!=Null && $shipping_id!=Null){
								?>
									<li><a href="{{URL::to('/payment')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
									}else {
								?>
									<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-crosshairs"></i> Thanh toán</a></li>
								<?php
									}
								?>

								<li><a href="{{url('/gio-hang')}}"><i class="fa fa-shopping-cart"></i>Giỏ hàng<span class="show-cart"></span>
								</a></li>
								
								<?php
									$customer_id=Session::get('customer_id');
									if($customer_id!=Null){
								?>
									<li>
										<a href="{{URL::to('/history')}}"><i class="fa fa-history"></i> Lịch sử</a>
									</li>								
								<?php
									}
								?>

								<?php
									$customer_id=Session::get('customer_id');
									if($customer_id!=Null){
								?>
									<li><a href="{{URL::to('/logout-checkout')}}"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
								<?php
									}else {
								?>
									<li><a href="{{URL::to('/login-checkout')}}"><i class="fa fa-sign-out"></i> Đăng nhập</a></li>

								<?php
									}
								?>
							

							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
	
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse" >
								<li><a href="{{URL::to('/trang-chu')}}">Trang Chủ</a>
								</li>
								<li><a href="{{URL::to('/show-cart')}}">Giỏ hàng
									<span class="show-cart"></span>
								</a></li>
								<li><a href="{{URL::to('/lien-he')}}">Liên hệ</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-4">
						<form action="{{URL::to('/tim-kiem')}}" method="POST">
							@csrf
							<div class="search_box pull-right">
								<input type="text" name="keywords" placeholder="Nhập từ khóa"/>
								<input type="submit" name="search_item" class="btn btn-info btn-sm" value="Tìm" >
							</div>
						</form>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header><!--/header-->
	
	<section id="slider"><!--slider-->
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						
						<div class="carousel-inner">
							@php
								$i=0;
							@endphp
							@foreach($slider as $key => $slide)
							@php
								$i++;
							@endphp
							<div class="item {{$i==1 ? 'active' : ''}}" >
								<div class="col-sm-6">
									<h1><span>TuanAnh</span>Store</h1>
									<h2>Chào mừng bạn đến TuanAnh-Store</h2>
									{{-- <p>{{$slide->slider_desc}}</p> --}}
									{{-- <button type="button" class="btn btn-default get">Khám phá ngay!</button> --}}
								</div>
								<div class="col-sm-6">
									<img src="{{asset('uploads/slider/'. $slide->slider_image)}}" class="girl img-responsive" alt="" />
								</div>
							</div>	
							@endforeach
						</div>
						
						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--/slider-->
	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<div class="left-sidebar">
						<h2>Danh mục sản phẩm</h2>
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->
							@foreach ($category as $key => $cate) <!-- foreach ($cate_product as $key => $cate  -Đây là cách 2)-->
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title"><a style="color: red" href="{{URL::to('/danh-muc-san-pham/'.$cate->category_id)}}">{{$cate->category_name}}</a></h4>
								</div>
							</div>
							@endforeach
						</div><!--/category-products-->
					
						<div class="brands_products"><!--brands_products-->
							<h2>Thương hiệu sản phẩm</h2>
							<div class="brands-name">
								<ul class="nav nav-pills nav-stacked">
								@foreach ($brand as $key => $brand) <!-- foreach ($brand_product as $key => $brand) -Đây là cách 2-->
									<li><a style="color: red" href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}"> {{$brand->brand_name}}</a></li>
								@endforeach
								</ul>
							</div>
						</div><!--/brands_products-->
						
					</div>
				</div>
				
				<div class="col-sm-9 padding-right">
					@yield('content')
				</div>
			</div>
		</div>
	</section>
	
	<footer id="footer"><!--Footer-->
		<div class="footer-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="companyinfo">
							<h2><span>TuanAnh</span>Store</h2>
							<p>Xin cảm ơn quý khách đã ghé thăm shop</p>
						</div>
					</div>
					<div class="col-sm-7">
						<div class="logo pull-left">
							<a href="/trang-chu"><img id="imglogo1" src="{{asset('frontend/images/logo.png')}}" alt="" /></a>
						</div>	
					</div>
					<div class="col-sm-3">
						<div class="address">
							<img src="{{asset('frontend/images/map.png')}}" alt="" />
							<p>Đường 212, Tiên Lãng, Hải Phòng</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="footer-widget">
			<div class="container">
				<div class="row">
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Dịch vụ</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Trợ giúp trực tuyến</a></li>
								<li><a href="#">Liên hệ với chúng tôi</a></li>
								<li><a href="#">Trạng thái giao hàng</a></li>
								<li><a href="#">Thay đổi địa chỉ</a></li>
								<li><a href="#">Câu hỏi thường gặp</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Cửa hàng nhanh</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">T-Shirt</a></li>
								<li><a href="#">Nam</a></li>
								<li><a href="#">Nữ</a></li>
								<li><a href="#">Giày</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Chính sách</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Điều khoản</a></li>
								<li><a href="#">Bảo mật</a></li>
								<li><a href="#">Hoàn trả</a></li>
								<li><a href="#">Hóa đơn thanh toán</a></li>
								<li><a href="#">Khuyễn mãi</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="single-widget">
							<h2>Giới thiệu cửa hàng</h2>
							<ul class="nav nav-pills nav-stacked">
								<li><a href="#">Thông tin</a></li>
								<li><a href="#">Vị trị</a></li>
								<li><a href="#">Liên kết</a></li>
								<li><a href="#">Bản quyền</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-3 col-sm-offset-1">
						<div class="single-widget">
							<h2>Đăng ký email nhận thông tin</h2>
							<form action="#" class="searchform">
								<input type="text" placeholder="Địa chỉ email của bạn" />
								<button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
								<p>Để nhận các thông tin cập nhật mới nhất <br />dành cho bạn</p>
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">© 2021 Bản quyền thuộc TuanAnh-Store. Tất cả các quyền được bảo lưu.</p>
					<p class="pull-right">Thiết kế bởi <span><a target="_blank" href="https://www.facebook.com/tuananh107698">Tuấn Anh</a></span></p>
				</div>
			</div>
		</div>
		
	</footer><!--/Footer-->
  
    <script src="{{asset('frontend/js/jquery.js')}}"></script>
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('frontend/js/jquery.scrollUp.min.js')}}"></script>
	<script src="{{asset('frontend/js/price-range.js')}}"></script>
    <script src="{{asset('frontend/js/jquery.prettyPhoto.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>
	<script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
	<script src="{{asset('frontend/js/lightgallery-all.min.js')}}"></script>
	<script src="{{asset('frontend/js/lightslider.js')}}"></script>
	<script src="{{asset('frontend/js/prettify.js')}}"></script>

	<script text="text/javascript">
        $('.xemnhanh').click(function(){
			var product_id = $(this).data('id_product');
            var _token = $('input[name="_token"]').val();

			$.ajax({
				url:"{{url('/quickview')}}",
				method: "POST",
				dataType: "JSON",
				data: {product_id:product_id, _token:_token},
				success:function(data){
					$('#product_quickview_title').html(data.product_name);
					$('#product_quickview_id').html(data.product_id);
					$('#product_quickview_price').html(data.product_price);
					$('#product_quickview_image').html(data.product_image);
					$('#product_quickview_quantity').html(data.product_quantity);
					$('#product_quickview_desc').html(data.product_desc);
					$('#product_quickview_content').html(data.product_content);
					$('#product_quickview_color').html(data.product_color);
					$('#product_quickview_size').html(data.product_size);
				}
			});
		});
    </script>

	<script text="text/javascript">
		function Huydonhang(id){
			var order_code = id;
			var reason = $('.reason_cancel').val();
			var _token = $('input[name="_token"]').val();
			
			$.ajax({
					url : '{{url('/cancel-order')}}',
					method: "POST",
					data:{order_code:order_code, reason:reason, _token:_token},
					success:function(data){
                    	alert('Hủy đơn hàng thành công');
						location.reload();
                	}
            	});
		}
	</script>
	
	<!--Ảnh-->
	<script text="text/javascript">
		$(document).ready(function() {
			$('#imageGallery').lightSlider({
				gallery:true,
				item:1,
				loop:true,
				thumbItem:3,
				slideMargin:0,
				enableDrag: false,
				currentPagerPosition:'left',
				onSliderLoad: function(el) {
					el.lightGallery({
						selector: '#imageGallery .lslide'
					});
				}   
			});  
		});
	</script>

	<!--Order-->
	<script text="text/javascript">
		$(document).ready(function(){
			$('.send_order').click(function(){
				swal({
					title: "Xác nhận đơn hàng",
					text: "Bạn có chắc chắn muốn đặt hàng không?",
					type: "warning",
					showCancelButton: true,
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Đồng ý",

					cancelButtonText: "Thoát",
					closeOnConfirm: false,
					closeOnCancel: false
                },
				function(isConfirm){
					if (isConfirm) {
						var shipping_email =  $('.shipping_email').val();
						var shipping_name =  $('.shipping_name').val();
						var shipping_address =  $('.shipping_address').val();
						var shipping_phone =  $('.shipping_phone').val();
						var shipping_method =  $('.payment_select').val();  
						var shipping_note =  $('.shipping_note').val();  
						var order_fee =  $('.order_fee' ).val();  
						var order_coupon =  $('.order_coupon').val();  
						var _token = $('input[name="_token"]').val();

						$.ajax({
							url: '{{url('/confirm-order')}}',
							method: 'POST',
							data:{
								shipping_email:shipping_email,
								shipping_name:shipping_name,
								shipping_address:shipping_address,
								shipping_phone:shipping_phone,
								shipping_method:shipping_method,
								shipping_note:shipping_note,
								order_fee:order_fee,
								order_coupon:order_coupon,
								_token:_token
							},
							success:function(){
								swal("Đơn hàng", "Đơn hàng của bạn đã được gửi thành công", "success");
							}
						});
						window.setTimeout(function(){ 
                            window.location.href = "{{url('/history')}}";
                        } ,2000);
					}else{
						swal("Đóng", "Đơn hàng chưa được gửi !", "error");
					}
				});
				
			});
		});
	</script>

	<!--Tính phí vận chuyển Thanh toán-->
	<script type="text/javascript">
		$(document).ready(function(){
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
					url : '{{url('/select-delivery-home')}}',
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

	<script type="text/javascript">
        $(document).ready(function(){
			$('.calculate_delivery').click(function(){
				var matp = $('.city').val();
				var maqh = $('.province').val();
				var xaid = $('.ward').val();
				var _token = $('input[name="_token"]').val();

				if(matp=='' && maqh=='' && xaid==''){
					alert('Lựa chọn để tính phí vận chuyển');
				}else{
					$.ajax({
					url : '{{url('/calculate-fee')}}',
					method: 'POST',
					data:{matp:matp,maqh:maqh,xaid:xaid,_token:_token},
					success:function(){
						// nếu chọn city thì biến province sẽ đặt vào id(#)
                    	location.reload();
                	}
            	});
				}
			});
		});

	</script>

	<!--Thêm sản phẩm vào giỏ hàng ajax-->
	<script type="text/javascript">
        $(document).ready(function(){
			show_cart();
			//show cart quantity
			function show_cart(){
				$.ajax({
					url : '{{url('/show-cart-update')}}',
					method: "GET",
					success:function(data){
                    	$('.show-cart').html(data);
                	}
            	});
			}
            $('.add-to-cart').click(function(){
                var id = $(this).data('id_product');
				var cart_product_id =  $('.cart_product_id_' + id).val();
				var cart_product_name =  $('.cart_product_name_' + id).val();
				var cart_product_quantity =  $('.cart_product_quantity_' + id).val();
				var cart_product_image =  $('.cart_product_image_' + id).val();
				var cart_product_price =  $('.cart_product_price_' + id).val();
				var cart_product_qty =  $('.cart_product_qty_' + id).val();  
				var cart_product_size =  $('.cart_product_size_' + id).val();  
				var cart_product_color =  $('.cart_product_color_' + id).val();  
				var _token = $('input[name="_token"]').val();

				if(parseInt(cart_product_qty)>parseInt(cart_product_quantity)){
					alert('Số lượng hàng đặt vượt quá' +cart_product_quantity);
				}else{
					$.ajax({
						url: '{{url('/add-cart-ajax')}}',
						method: 'POST',
						data:{
							cart_product_id:cart_product_id,
							cart_product_name:cart_product_name,
							cart_product_quantity:cart_product_quantity,
							cart_product_image:cart_product_image,
							cart_product_price:cart_product_price,
							cart_product_qty:cart_product_qty,
							cart_product_color:cart_product_color,
							cart_product_size:cart_product_size,
							_token:_token
						},
						success:function(){
							swal({
									title: "Đã thêm sản phẩm vào giỏ hàng",
									text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
									showCancelButton: true,
									cancelButtonText: "Xem tiếp",
									confirmButtonClass: "btn-success",
									confirmButtonText: "Đi đến giỏ hàng",
									closeOnConfirm: false
								},
								function() {
									window.location.href = "{{url('/gio-hang')}}";
								});
							show_cart();
						}
					});
				}
            });
        });
    </script>
</body>
</html>