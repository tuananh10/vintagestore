@extends('layout')
@section('content')
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
            @foreach ($get_order as $key => $ord )
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
                @if($ord->order_status==1)
                  <!-- Trigger the modal with a button -->
                  <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#huydon">Hủy đơn</button>
                @endif
                <!-- Modal -->
                <div id="huydon" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <form>
                      @csrf
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Lý do hủy đơn</h4>
                      </div>
                      <div class="modal-body">
                        <p><textarea rows="5" class="reason_cancel" required placeholder="Nhập lý do"></textarea></p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                        <button type="button" id="{{$ord ->order_code}}" onclick="Huydonhang(this.id)" class="btn btn-success">Gửi</button>
                      </div>
                    </div>
                    </form>
                    
                  </div>
                </div>
                <a href="{{URL::to('/view-history-order/'.$ord ->order_code)}}" class="active styling-edit" ui-toggle-class="">Xem đơn</a>
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
              {{ $get_order->links('vendor.pagination.custom') }}
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
@endsection
