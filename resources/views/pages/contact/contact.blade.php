@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
    <h2 class="title text-center">Liên hệ với chúng tôi</h2>
    <div class="row">
        @foreach ($contact as $cont)

        <div class="col-md-12">
            <h4>Thông tin liên hệ</h4>
            {!!$cont->info_contact!!} 
            {!!$cont->info_fanpage!!} 
        </div>
        <div class="col-md-12">
            <h4>Bản đồ</h4>
            {!!$cont->info_map!!} 
        </div>
        @endforeach
    </div>
</div><!--features_items-->
@endsection
