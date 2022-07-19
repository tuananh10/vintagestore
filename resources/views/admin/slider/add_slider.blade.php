@extends('admin_layout')
@section('admin_content')
    
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm Slider
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
                        <form role="form" action="{{URL::to('/insert-slider')}}" enctype="multipart/form-data" method="post">
                            @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên slide</label>
                            <input type="text" name="slider_name" class="form-control" id="exampleInputEmail1" placeholder="Tên slide">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh</label>
                            <input type="file" name="slider_image" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả</label>
                            <textarea style="resize: none" rows="6" class="form-control" name="slider_desc" id="exampleInputPassword1" placeholder="Mô tả"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="slider_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>
                        <button type="submit" name="add_slider" class="btn btn-info">Thêm Slider</button>
                    </form>
                    </div>

                </div>
            </section>
    </div>
</div>
@endsection
