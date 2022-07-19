@extends('layout')
@section('content')

<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
              <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
              <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div>

        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
        </div>
        <div class="table-responsive cart_info">
            @php
            $content = Cart::content();
            // echo'<pre>';
            //     print_r($content);
            // echo'<pre>';
            @endphp
            <table class="table table-condensed">
                <thead>
                    <tr class="cart_menu">
                        <td class="image">Hình ảnh</td>
                        <td class="description">Tên sản phẩm</td>
                        <td class="quantity">Số lượng</td>
                        <td class="color">Color</td>
                        <td class="size">Size</td>
                        <td class="price">Giá</td>
                        <td class="total">Tổng</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($content as $v_content) 
                    <tr>
                        <td class="cart_product">
                            <a href=""><img width="50" src={{URL::to('uploads/product/'.$v_content->options->image)}} alt=""></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href="">{{$v_content->name}}</a></h4>
                            <p>Mã ID: {{$v_content->id}}</p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <form action="{{URL::to('/update-cart-quantity')}}" method="POST">
                                    @csrf
                                    {{-- <input class="" name="qty" type="number" min="1" value="1" /> --}}
                                    <input class="cart_quantity_input " type="number" min="1" name="cart_quantity" value="{{$v_content->qty}}" size="2">
                                    <input type="hidden" value="{{$v_content->rowId}}" name="rowId_cart" class="form-control">
                                    <button type="submit" value="" name="update_qty" class="btn btn-info"><span style="font-family: wingdings; font-size: 90%;">&#10004;</span></button>
                                </form>
                            </div>
                        </td>
                        <td class="cart_color">
                            <p>{{$v_content->options->color}}</p>
                        </td>
                        <td class="cart_size">
                            <p>{{$v_content->options->size}}</p>
                        </td>
                        <td class="cart_price">
                            <p>{{number_format($v_content->price).' '.'VNĐ'}}</p>
                        </td>
                        
                        <td class="cart_total">
                            <p class="cart_total_price">
                                @php
                                    $subtotal = ($v_content->price) * ($v_content->qty);
                                    echo number_format($subtotal).' '.'VNĐ';
                                @endphp
                            </p>
                        </td>
                        <td class="cart_delete">
                            <a class="cart_quantity_delete" href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="select_payment1">
            <h4>Chọn hình thức thanh toán</h4>
        </div>
        <form action="{{url::to('/order-info')}}" method="POST">
            @csrf
        <div class="payment-options">
                <span>
                    <label><input name="payment_option" value="1" type="checkbox"> Thanh toán bằng thẻ ATM</label>
                </span>
                <span>
                    <label><input name="payment_option" value="2" type="checkbox"> Thanh toán khi nhận hàng</label>
                </span>
                <span>
                    <label><input name="payment_option" value="3" type="checkbox"> Thanh toán bằng phương thức khác</label>
                </span>
                <input type="submit" value="Đặt hàng" name="send_payment" class="btn btn-primary btn-sm">
        </div>
        </form>
    </div>
</section> <!--/#cart_items-->

@endsection