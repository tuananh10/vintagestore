@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="pay active">Thanh toán giỏ hàng</li>
            </ol>
        </div>

        <div class="register-req">
            <p>Hãy đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lịch sử mua hàng</p>
        </div><!--/register-req-->
        @if(\Session::has('error'))
            <div class="alert alert-danger">{{ \Session::get('error') }}</div>
        {{ \Session::forget('error') }}
        @endif
        @if(\Session::has('success'))
            <div class="alert alert-success">{{ \Session::get('success') }}</div>
            {{ \Session::forget('success') }}
        @endif
        <div class="shopper-informations"> 
            <div class="row">
                {{-- <style type="text/css">
                    .col-md-6.form-style input[type=text]{
                        margin: 5px 0;
                    }
                </style> --}}
                <div class="col-sm-6 clearfix">
                    
                    <div class="bill-to">
                        <p>Thông tin hóa đơn</p>
                        <div class="form-one" id="form-one">
                            <form method="POST">
                                @csrf
                                <input type="text" name="shipping_email" class="shipping_email" placeholder="Email*">
                                <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên *">
                                <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại *">
                                <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ *">
                                <textarea name="shipping_note" class="shipping_note"  placeholder="Ghi chú về đơn hàng của bạn" rows="4"></textarea>
                                
                                {{-- Phí --}}
                                @if(Session::get('fee'))
                                    <input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
                                @else
                                    <input type="hidden" name="order_fee" class="order_fee" value="30000">
                                @endif

                                {{-- Mã KM --}}
                                @if(Session::get('coupon'))
                                    @foreach (Session::get('coupon') as $key => $cou)
                                        <input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                                    @endforeach
                                @else
                                    <input type="hidden" name="order_coupon" class="order_coupon" value="No">
                                @endif          
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                                @if(!Session::get('success_paypal')==true)
                                    <select name="payment_select" class="form-control input-sm m-bot15 payment_select">
                                        <option value="0">Chuyển khoản</option>
                                        <option value="1">Thanh toán khi nhận hàng</option>
                                    </select>
                                @else
                                <select name="payment_select" class="form-control input-sm m-bot15 payment_select">
                                    <option value="2">Đã thanh toán bằng Paypal</option>
                                </select>
                                @endif
                                </div>
                                <div class="form-group">
                                    <a class="btn btn-primary m-3" href="{{ route('processTransaction') }}">Thanh toán bằng Paypal</a>
                                </div>
                                <input type="button" value="Xác nhận đơn hàng" name="send_order" class="btn btn-primary btn-sm send_order">
                            </form>
                        </div>
                    </div>
                </div>	
                <div class="col-sm-6 clearfix">
                    <div class="bill-to">
                        <p>Phí vận chuyển</p>
                        <div class="form-one" id="form-one">
                            <form>
                                @csrf   
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn tỉnh/thành phố</label>
                                    <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                        <option value="">---Chọn tỉnh/thành phố---</option>
                                        @foreach ($city as $key => $ct)
                                            <option value="{{$ct->matp}}">{{$ct->name_city}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn quận/huyện</label>
                                    <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                        <option value="">---Chọn quận/huyện---</option>
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn xã/phường</label>
                                    <select name="ward" id="ward" class="form-control input-sm m-bot15 ward">
                                        <option value="">---Chọn xã/phường---</option>                 
                                    </select>
                                </div>
                                <input type="button" value="Tính phí vận chuyển" name="calculate_delivery" class="btn btn-primary calculate_delivery">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
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
                                    <input class="cart_quantity_input" type="number" 
                                    @if(Session::get('success_paypal')==true)
                                        readonly
                                    @endif
                                    min="1" name="cart_qty[{{$val_cart['session_id']}}]" value="{{$val_cart['product_qty']}}" size="2">
                                    <input type="hidden" value="" name="rowId_cart" class="form-control">
                                    <button type="submit" value="" name="update_qty" class="btn btn-info"><span style="font-family: wingdings; font-size: 90%;">&#10004;</span></button>
                                </form>
                            </div>
                        </td>
                        <td class="cart_color">
                            <p>{{$val_cart['product_color']}}</p>
                        </td>
                        <td class="cart_size">
                            <p>
                                @php
                                if($val_cart['product_size']==0){
                                    echo 'S'; 
                                  }else if($val_cart['product_size']==1){
                                    echo 'M';
                                  }else if($val_cart['product_size']==2){
                                    echo 'L';
                                  }else if($val_cart['product_size']==3){
                                    echo 'XL';
                                  }else if($val_cart['product_size']==4){
                                    echo 'XXL';
                                  }
                                  else{
                                    echo '';
                                  }
                                  @endphp</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($val_cart['product_price'],0,',','.')}} đ</p>
                        </td>
                        
                        <td class="cart_total">
                            <p class="cart_total_price">{{number_format($subtotal,0,',','.')}} đ</p>
                        </td>
                        <td class="cart_delete">
                            @if(!Session::get('success_paypal')==true)
                            <a class="cart_quantity_delete" href="{{url::to('delete-pro-ajax/'.$val_cart['session_id'])}}"><i class="fa fa-times"></i></a>
                            @endif
                        </td>
                    </tr>
                    
                    @endforeach
                    <tr>
                        @if(!Session::get('success_paypal')==true)
                        <td>
                            <a class="btn btn-default check_out" href="{{url('/delete-all-product')}}">Xóa tất cả sản phẩm</a>  
                        </td>
                        @endif
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
                                @if(!Session::get('success_paypal')==true)
                                <form class="form_coupon" action="{{url('/check-coupon')}}" method="POST">
                                    @csrf
                                    <input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá">
                                    <input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Chấp nhận">
                                </form>
                                @endif  
                        </div><br>
                        <div class="col-md-12">
                            @php
                                $vnd_to_usd = $total_after/22720;
                                $total_paypal = round($vnd_to_usd,2);
                                \Session::put('total_paypal',$total_paypal)
                            @endphp
                        </div>
                    </div>
                </div>
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