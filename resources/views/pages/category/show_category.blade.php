@extends('layout')
@section('content')

<div class="features_items"><!--features_items-->
                        @foreach ($category_name as $key => $cate_name)
						    <h2 class="title text-center">{{$cate_name->category_name}}</h2>
                        @endforeach
						@foreach ($category_by_id as $key => $all_pro)
                        <a href="{{URL::to('/chi-tiet-san-pham/'.$all_pro->product_id)}}">
						<div class="col-sm-4">
							<div class="product-image-wrapper">
								<div class="single-products">
										<div class="productinfo text-center">
											<img src="{{URL::to('uploads/product/'.$all_pro->product_image)}}" alt="" />
											<h4>{{number_format($all_pro->product_price,0,',','.').' '.'VNĐ'}}</h4>
											<p>{{$all_pro->product_name}}</p>
											<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
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
                        </a>
						@endforeach
						
					</div><!--features_items-->
@endsection