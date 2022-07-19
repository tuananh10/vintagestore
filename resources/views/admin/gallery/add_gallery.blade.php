@extends('admin_layout')
@section('admin_content')
    
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm thư viện ảnh
                </header>
                <div class="panel-body">
                    @php
                        $message = Session::get('message');
                        if($message){
                            echo "<span class='text-alert'> $message </span>";
                            Session::put('message',null);
                        }
                    @endphp
                    <form action="{{url('/insert-gallery/'.$prod_id)}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="row"> 
                      <div class="col-md-3" align="right">

                      </div>
                      <div class="col-md-6">
                        <input type="file" class="form-control" id="file" name="file[]" accept="image/*" multiple>
                        <span id="error_gallery"></span>
                      </div>
                      <div class="col-md-3">
                        <input type="submit" name="upload" value="Tải ảnh" class="btn btn-success">
                      </div>
                    </div>
                  </form>
                    <input type="hidden" value="{{$prod_id}}" name="prod_id" class="prod_id">
                    <form>
                      @csrf
                    <div id="gallery_load">
                    </div>
                  </form>
                </div>
            </section>
    </div>
</div>
@endsection
