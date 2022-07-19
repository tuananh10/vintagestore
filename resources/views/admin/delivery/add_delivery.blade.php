@extends('admin_layout')
@section('admin_content')
    
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm phí vận chuyện
                </header>
                <div class="panel-body">
                    @php
                        $message = Session::get('message');
                        if($message){
                            echo "<span class='text-alert'> $message </span>";
                            Session::put('message',null);
                        }
                    @endphp
                    <div class="position-center">
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
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phí</label>
                            <input type="text" name="fee_ship" class="form-control fee_ship" id="exampleInputEmail1" placeholder="Tên thương hiệu">
                        </div>
                        <button type="button" name="add_delivery" class="btn btn-info add_delivery">Thêm phí vận chuyển</button>
                    </form>
                    </div>
                    <br>
                    <div id="load_delivery">

                    </div>

                </div>
            </section>
    </div>
</div>
@endsection
