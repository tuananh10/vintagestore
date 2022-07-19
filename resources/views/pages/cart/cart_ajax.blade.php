@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="ca active">Giỏ hàng của bạn</li>
            </ol>
        </div>
        @if(session()->has('message'))
        <div class="alert alert-success">
            {!! session()->get('message') !!}
        </div>
        @elseif(session()->has('error'))
            <div class="alert alert-danger">
                {!! session()->get('error') !!}
            </div>
        @endif
        <div class="table-responsive cart_info">
            @if(Session::get('cart')==true)

            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Tên sản phẩm</td>
                        <td class="quantity">Số lượng</td>
                        <td class="color">Color</td>
                        <td class="size">Size</td>
                        <td class="price">Giá</td>
                        <td class="total">Thành tiền</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach(Session::get('cart') as $key => $val_cart) 
                        @php
                            $subtotal = $val_cart['product_qty']*$val_cart['product_price'];
                            $total += $subtotal; 
                        @endphp
                    <tr>
                        <td class="cart_product">
                            <img width="100" height="100" src="{{asset('uploads/product/'.$val_cart['product_image'])}}" alt="{{$val_cart['product_name']}}">
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$val_cart['product_name']}}</a></h4>
                            <p>Mã ID: {{$val_cart['product_id']}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{url::to('/update-cart-ajax')}}" method="POST">
                                    @csrf
                                    {{-- <input class="" name="qty" type="number" min="1" value="1" /> --}}
                                    <input class="cart_quantity_input" type="number" min="1" name="cart_qty[{{$val_cart['session_id']}}]" 
                                    value="{{$val_cart['product_qty']}}" size="2">
                                    <input type="hidden" value="" name="rowId_cart" class="form-control">
                                    <button type="submit" value="" name="update_qty" class="btn btn-info">
                                        <span style="font-family: wingdings; font-size: 90%;">&#10004;</span></button>
                                </form>
                            </div>
                        </td>
                        <td class="cart_color">
                            <p>{{$val_cart['product_color']}}</p>
                        </td>
                        <td class="cart_size">
                            <p>{{$val_cart['product_size']}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($val_cart['product_price'],0,',','.')}} đ</p>
                        </td>
                        
                        <td class="cart_total">
                            <p class="cart_total_price">{{number_format($subtotal,0,',','.')}} đ</p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{url::to('delete-pro-ajax/'.$val_cart['session_id'])}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    
                    @endforeach
                    <tr>
                        <td>
                            <a class="btn btn-default check_out" href="{{url('/delete-all-product')}}">Xóa tất cả sản phẩm</a>
                        </td>

                    </tr>
                </tbody>
            </table>

            <div class="container">
                <div class="heading">
                    <h3>Thanh toán giỏ hàng</h3>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="total_area">
                            <div class="total_area">
                                <ul>
                                    <li>Tổng tiền: {{number_format($total,0,',','.')}} đ</li>
                                    {{-- <li>Thuế: <span></span></li>--}}
                                    @if(Session::get('fee'))
                                    <li>
                                        Phí vận chuyển: {{number_format(Session::get('fee'),0,',','.')}} đ
                                        <span><a class="cart_quantity_delete" href="{{url::to('/delete-fee')}}"><i class="fa fa-times"></i></a></span>
                                        @php
                                            $total_after_feeship = $total + Session::get('fee') 
                                        @endphp
                                    </li>
                                    @endif
                                        @if(Session::get('coupon'))
                                            @foreach(Session::get('coupon') as $key => $cou)
                                                @if($cou['coupon_condition'] ==1)
                                                    <li>
                                                        Mã giảm giá: {{$cou['coupon_number']}}%
                                                        <span><a class="cart_quantity_delete" href="{{url::to('/unset-coupon')}}"><i class="fa fa-times"></i></a></span>
                                                    </li>
                                                    <p>
                                                        @php
                                                            $total_coupon = ($total*$cou['coupon_number'])/100;
                                                        @endphp
                                                    </p>
                                                    <p>
                                                        @php
                                                            $total_after_coupon = $total - $total_coupon;
                                                        @endphp
                                                    </p>
                                                @elseif($cou['coupon_condition'] ==2)
                                                    <li>
                                                        Mã giảm giá: {{number_format($cou['coupon_number'])}} đ 
                                                        <span><a class="cart_quantity_delete" href="{{url::to('/unset-coupon')}}"><i class="fa fa-times"></i></a></span>
                                                    </li>
                                                    <p>
                                                        @php
                                                            $total_coupon = $total-$cou['coupon_number'];
                                                        @endphp
                                                    </p>
                                                    <p>
                                                        @php
                                                            $total_after_coupon = $total_coupon;
                                                        @endphp
                                                    </p>
                                                @endif
                                            @endforeach
                                        @endif
                                        <li>
                                            @php
                                                if(Session::get('fee') && !Session::get('coupon')){
                                                    $total_after = $total_after_feeship;
                                                    echo '<p>Thành tiền: '.number_format($total_after,0,',','.').'đ</p>';
                                                }elseif(!Session::get('fee') && Session::get('coupon')){
                                                    $total_after = $total_after_coupon;
                                                    echo '<p>Thành tiền: '.number_format($total_after,0,',','.').'đ</p>';
                                                }elseif(Session::get('fee') && Session::get('coupon')){
                                                    $total_after = $total_after_coupon;
                                                    $total_after = $total_after + Session::get('fee');
                                                    echo '<p>Thành tiền: '.number_format($total_after,0,',','.').'đ</p>';
                                                }elseif(!Session::get('fee')&& !Session::get('coupon')){
                                                    $total_after = $total;
                                                    echo '<p>Thành tiền: '.number_format($total_after,0,',','.').'đ</p>';
                                                }
                                            @endphp
                                        </li>
                                </ul>
                            </div>
                                <form class="form_coupon" action="{{url('/check-coupon')}}" method="POST">
                                    @csrf
                                    <input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá">
                                    <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Chấp nhận">
                                </form>
                        </div>
                    </div>
                </div>
                @if(Session::get('customer_id'))
                    <a class="btn btn-default check_out" id="checkout1" href="{{url('/checkout')}}">Đặt hàng</a>  
                @else
                    <a class="btn btn-default check_out" id="checkout1" href="{{url('/login-checkout')}}">Đặt hàng</a>  
                @endif
            </div>
            @else 
            <a href="{{url('/trang-chu')}}" class="btn btn-danger">
            @php
                echo'Giỏ hàng trống. Vui lòng thêm sản phẩm vào giỏ hàng';
            @endphp
            </a>
            @endif
        </div>
    </div>
</section> <!--/#cart_items-->

@endsection