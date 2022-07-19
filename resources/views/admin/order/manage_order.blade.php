@extends('admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Liệt kê đơn hàng
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
              <th>Thứ tự</th>
              <th>Mã đơn hàng</th>
              <th>Ngày đặt hàng</th>
              <th>Tình trạng đơn hàng</th>
              
              <th style="width:30px;"></th>
            </tr>
          </thead>
          <tbody>
            @php
                $i = 0 ;
            @endphp
            @foreach ($order as $key => $ord )
            @php
                $i++;
            @endphp
            <tr>
              <td><label class="i-checks m-b-none"><i> {{$i}}</i></label></td>
              <td>{{ $ord ->order_code}}</td>
              <td>{{ $ord ->created_at}}</td>
              <td><span class="text-ellipsis">
                @if($ord->order_status==1)
                  <span class="text text-info">Đơn hàng mới</span> 
                @elseif($ord->order_status==2)
                  <span class="text text-success">Đã xử lý</span>
                @else
                  <span class="text text-danger">Đơn hàng bị hủy</span> 
                @endif
              </span></td>
              <td>
                <a href="{{URL::to('/view-order/'.$ord ->order_code)}}" class="active styling-edit" ui-toggle-class=""><i class="fa fa-eye text-success text-active"></i></a>
                <a href="{{URL::to('/delete-order/'.$ord ->order_code)}}" class="active styling-delete" onclick="return confirm('Bạn có chắc muốn xóa thương hiệu này không?')" ui-toggle-class=""><i class="fa fa-times text-danger text"></i></a>
              </td>
            </tr>                      
            @endforeach
          </tbody>
        </table>
      </div>
      <footer class="panel-footer">
        <div class="row">
          
          <div class="col-sm-7 text-right text-center-xs">                
            <ul class="pagination pagination-sm m-t-none m-b-none">
              {!!$order->links()!!}
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
@endsection
