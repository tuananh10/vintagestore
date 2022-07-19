@extends('admin_layout')
@section('admin_content')
    
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm thông tin website
                </header>
                @php
                    $message = Session::get('message');
                    if($message){
                        echo "<span class='text-alert'> $message </span>";
                        Session::put('message',null);
                    }
                @endphp
                <div class="panel-body">
                    @foreach($contact as $key => $val)
                    <div class="position-center">
                        <form role="form" action="{{URL::to('/update-info/'.$val->info_id)}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputPassword1">Thông tin liên hệ</label>
                                <textarea style="resize: none" rows="6" class="form-control" name="info_contact" id="ckeditor1">{{$val->info_contact}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Bản đồ</label>
                                <textarea style="resize: none" rows="6" class="form-control" name="info_map" id="exampleInputPassword1">{{$val->info_map}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Fanpage</label>
                                <textarea style="resize: none" rows="6" class="form-control" name="info_fanpage" id="exampleInputPassword1">{{$val->info_fanpage}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh logo </label>
                                <input type="file" height="100" width="100" name="info_logo" class="form-control" id="exampleInputEmail1">
                                <img src="{{URL::to('uploads/contact/'.$val->info_logo)}}" height="100" width="100">
                            </div>
                            <button type="submit" name="add_info" class="btn btn-info">Cập nhật thông tin</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </section>
    </div>
</div>
@endsection
