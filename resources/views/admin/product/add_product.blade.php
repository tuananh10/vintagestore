@extends('admin_layout')
@section('admin_content')
    
<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm sản phẩm
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
                        <form role="form" action="{{URL::to('/save-product')}}" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm </label>
                            <input type="text" data-validation="length" data-validation-length="min10" data-validation-error-msg="Làm ơn điền đủ 10 ký tự"
                            name="product_name" class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm ">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Số lượng sản phẩm</label>
                            <input type="text" data-validation="number"  data-validation-error-msg="Làm ơn điền số lượng" name="product_quantity" class="form-control" id="exampleInputEmail1" placeholder="Điền số lượng">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm </label>
                            <input type="file" height="100" width="100" name="product_image" class="form-control" id="exampleInputEmail1">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm </label>
                            <input type="text" data-validation="length" name="product_price"  data-validation-length="min6" 
                            data-validation-error-msg="Làm ơn điền số tiền" class="form-control price_format" id="exampleInputEmail1" placeholder="Giá">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá gốc sản phẩm </label>
                            <input type="text" data-validation="length" name="price_cost" data-validation-error-msg="Làm ơn điền số tiền" data-validation-length="min6" class="form-control price_format" id="exampleInputEmail1" placeholder="Giá gốc">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows="6" class="form-control" name="product_desc" id="exampleInputPassword1" placeholder="Mô tả sản phẩm "></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                            <textarea style="resize: none" rows="6" class="form-control" name="product_content" id="exampleInputPassword1" placeholder="Nội dung sản phẩm "></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                            <select name="product_cate" class="form-control input-sm m-bot15">
                                @foreach ($cate_product as $key => $cate)
                                    <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>   
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Thương hiệu</label>
                            <select name="product_brand" class="form-control input-sm m-bot15">
                                @foreach ($brand_product as $key => $brand)
                                <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>   
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kích thước</label>
                            <input type="text" name="product_size" class="form-control" id="exampleInputEmail1" placeholder="Kích thước sản phẩm ">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Màu sắc</label>
                            <input type="text" name="product_color" class="form-control" id="exampleInputEmail1" placeholder="Màu sắc sản phẩm ">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Hiển thị</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="0">Ẩn</option>
                                <option value="1">Hiển thị</option>
                            </select>
                        </div>
                        <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
                    </form>
                    </div>

                </div>
            </section>
        </div>
</div>
@endsection
