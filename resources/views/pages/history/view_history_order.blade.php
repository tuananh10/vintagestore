@extends('layout')
@section('content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Xem chi tiết đơn hàng
      </div>
      <div class="table-responsive">
        @php
          $message = Session::get('message');
          if($message){
          echo "<span class='text-alert'> $message </span>";
          Session::put('message',null);
          }
        @endphp
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
                
              <th>Tên khác hàng</th>
              <th>Số điện thoại</th>
              <th>Email</th>

              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td>{{$customer->customer_name}}</td>
              <td>{{$customer->customer_phone}}</td>
              <td>{{$customer->customer_email}}</td>
            </tr>      
                           
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <br>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Thông tin vận chuyển
      </div>
      <div class="table-responsive">
        @php
          $message = Session::get('message');
          if($message){
          echo "<span class='text-alert'> $message </span>";
          Session::put('message',null);
          }
        @endphp
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>Tên người vận chuyển</th>
              <th>Số điện thoại</th>
              <th>Địa chỉ</th>
              <th>Email</th>
              <th>Ghi chú</th>
              <th>Hình thức thanh toán</th>

              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>

            <tr>
              <td>{{$shipping->shipping_name}}</td>
              <td>{{$shipping->shipping_phone}}</td>
              <td>{{$shipping->shipping_address}}</td>
              <td>{{$shipping->shipping_email}}</td>
              <td>{{$shipping->shipping_note}}</td>
              <td>
                @if($shipping->shipping_method==0) 
                  Chuyển khoản 
                @elseif($shipping->shipping_method==1)
                  Tiền mặt
                @else 
                  Paypal
                @endif
              </td>
            </tr>      
                           
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <br>
  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê chi tiết đơn hàng
      </div>
      <div class="table-responsive">
        @php
          $message = Session::get('message');
          if($message){
          echo "<span class='text-alert'> $message </span>";
          Session::put('message',null);
          }
        @endphp
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              <th>STT</th>
              <th>Tên sản phẩm</th>
              <th>Số lượng còn</th>
              <th>Mã giảm giá</th>
              <th>Kích thước</th>
              <th>Màu sắc</th>
              <th>Số lượng</th>
              <th>Giá</th>
              <th>Phí ship</th>
              <th>Tổng tiền</th>
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @php
                $i=0;
                $total=0;
            @endphp
            @foreach ($order_details as $key =>$ord_de)
                @php
                  $i++;
                  $subtotal = $ord_de->product_price*$ord_de->product_sales_quantity;
                  $total += $subtotal;
                @endphp
            <tr>
              <td><label class="i-checks m-b-none"><i>{{$i}}</i></label></td>
              <td>{{$ord_de->product_name}}</td>
              <td>{{$ord_de->product->product_quantity}}</td>
              <td>
                @if($ord_de->product_coupon!='No')
                  {{$ord_de->product_coupon}}
                @else
                  Không
                @endif
              </td>
              <td>{{$ord_de->product_size}}</td>
              <td>{{$ord_de->product_color}}</td>
              <td>
                <input id="ip_or" type="number" readonly min="1" {{$order_status==2 ? 'disabled' : ''}} class="order_qty_{{$ord_de->product_id}}" value="{{$ord_de->product_sales_quantity}}" name="product_sales_quantity">
                <input type="hidden" name="order_qty_storage" class="order_qty_storage_{{$ord_de->product_id}}" value="{{$ord_de->product->product_quantity}}">
                <input type="hidden" name="order_code" class="order_code" value="{{$ord_de->order_code}}">
                <input type="hidden" name="order_product_id" class="order_product_id" value="{{$ord_de->product_id}}">
              </td>
              <td>{{number_format($ord_de->product_price,0,',','.')}} đ</td>
              <td>{{number_format($ord_de->product_feeship,0,',','.')}} đ</td>
              <td>{{number_format($subtotal,0,',','.')}} đ</td>
            </tr>      
            @endforeach           
          </tbody>
        </table>
        <br>
        <div>
          @php
              $total_coupon = 0;
          @endphp
          {{-- Tính theo điều kiện giảm % --}}
          @if($coupon_condition == 1) 
          @php
            $total_after_coupon = ($total*$coupon_number)/100;
            echo '<h4>Tiền giảm: '.number_format($total_after_coupon,0,',','.'). 'đ'.'</h4>';
            $total_coupon = $total - $total_after_coupon + $ord_de->product_feeship;
          @endphp
          {{-- Tính theo điều kiện giảm tiền --}}
          @else
            @php
              echo '<h4>Tiền giảm: '.number_format($coupon_number,0,',','.'). 'đ'.'</h4>';
              $total_coupon = $total-$coupon_number + $ord_de->product_feeship;
            @endphp
          @endif
          <h4 class="thanhtoan" style="color: red">Thanh toán: {{number_format($total_coupon,0,',','.')}} đ </h4> 
        </div>
      </div>
    </div>
  </div>
@endsection
