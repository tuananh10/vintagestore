@extends('layout')
@section('content')

<div class="features_items"><!--features_items-->
	<h2 class="title text-center">Sản phẩm mới nhất</h2>

	@foreach ($all_product as $key => $all_pro)	
	<div class="col-sm-4">
		<div class="product-image-wrapper">
			<div class="single-products">
					<div class="productinfo text-center">
						<form>
							@csrf
						<input type="hidden" value="{{$all_pro->product_id}}" class="cart_product_id_{{$all_pro->product_id}}">
						<input type="hidden" value="{{$all_pro->product_name}}" class="cart_product_name_{{$all_pro->product_id}}">		
						<input type="hidden" value="{{$all_pro->product_quantity}}" class="cart_product_quantity_{{$all_pro->product_id}}">
						<input type="hidden" value="{{$all_pro->product_image}}" class="cart_product_image_{{$all_pro->product_id}}">
						<input type="hidden" value="{{$all_pro->product_price}}" class="cart_product_price_{{$all_pro->product_id}}">
						<input type="hidden" value="{{$all_pro->product_size}}" class="cart_product_size_{{$all_pro->product_id}}">
						<input type="hidden" value="{{$all_pro->product_color}}" class="cart_product_color_{{$all_pro->product_id}}">
						<input type="hidden" value="1" class="cart_product_qty_{{$all_pro->product_id}}">

						{{-- <a href="{{URL::to('/chi-tiet/'.$product->product_slug)}}"> --}}
						<a href="{{URL::to('/chi-tiet-san-pham/'.$all_pro->product_id)}}">
							<img src="{{URL::to('uploads/product/'.$all_pro->product_image)}}" alt="" />
							<h4>{{number_format($all_pro->product_price,0,',','.').' '.'VNĐ'}}</h4>
							<p>{{$all_pro->product_name}}</p>
						</a>	
						<style type="text/css">
							.xemnhanh{
								background: #F5F5ED;
								border: 0 none;
								border-radius: 0;
								color: #696763;
								font-family: 'Roboto', sans-serif;
								font-size: 15px;
								margin-bottom: 25px;
							}
						</style>
							<input style="background-color: yellowgreen" type="button" value="Thêm giỏ hàng" data-id_product="{{$all_pro->product_id}}" 
							class="btn btn-default add-to-cart" name="add-to-cart">
							<input style="background-color: antiquewhite" type="button" data-toggle="modal" data-target="#xemnhanh" value="Xem nhanh" 
							data-id_product="{{$all_pro->product_id}}" 
							class="btn btn-default xemnhanh" name="quick-view">
						</form>	
					</div>
			</div>
			{{-- <div class="choose">
				<ul class="nav nav-pills nav-justified">
					<li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
					<li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
				</ul>
			</div> --}}
		</div>
	</div>
	@endforeach

	</div><!--features_items-->
	<!-- Modal -->
<div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
	  <div class="modal-content">
		<div class="modal-header">
		  <h3 class="modal-title quickview_title">
			  <span id="product_quickview_title"></span>
		  </h3>
		  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
		  </button>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-md-5">
					<span id="product_quickview_image"></span>
				</div>
				<div class="col-md-7">
  					<h2 class="quickview"><span id="product_quickview_title"></span></h2>
					<p>Mã ID: <span id="product_quickview_id"></span></p>
					<span>
						<h4 style="color:#FE980F">Giá sản phẩm: <span id="product_quickview_price"></span></h4>
					</span><br>
					<p><b>Số lượng còn: <span id="product_quickview_quantity"></span></p>
					<p><b>Màu sắc: <span id="product_quickview_color"></span></p>
					<p><b>Kích thước: <span id="product_quickview_size"></span></p>
					
					<p class="quickview">Mô tả sản phẩm</p>
					<fieldset>
						<p>- <span id="product_quickview_desc"></span><br></p>
						<p>- <span id="product_quickview_content"></span></p>
					</fieldset>
				</div>
			</div>
				  
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
		</div>
	  </div>
	</div>
  </div>
  <ul class="pagination pagination-sm m-t-none m-b-none">
	{{ $all_product->links('vendor.pagination.custom') }}
  </ul>
@endsection