@extends('layout')
@section('content')

<div class="features_items"><!--features_items-->
	<h2 class="title text-center">Kết quả tìm kiếm</h2>

	@foreach ($search_product as $key => $search_pro)	
	<div class="col-sm-4">
		<div class="product-image-wrapper">
			<div class="single-products">
					<div class="productinfo text-center">
						<a href="{{URL::to('/chi-tiet-san-pham/'.$search_pro->product_id)}}">
							<img src="{{URL::to('uploads/product/'.$search_pro->product_image)}}" alt="" />
							<h4>{{number_format($search_pro->product_price,0,',','.').' '.'VNĐ'}}</h4>
							<p>{{$search_pro->product_name}}</p>
							<a href="{{URL::to('/chi-tiet-san-pham/'.$search_pro->product_id)}}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
						</a>	
					</div>
			</div>
			<div class="choose">
				<ul class="nav nav-pills nav-justified">
					<li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
					<li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
				</ul>
			</div>
		</div>
	</div>
	@endforeach

	</div><!--features_items-->
@endsection