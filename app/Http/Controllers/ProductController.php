<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Slider;
use App\Gallery;
use App\Product;
use Illuminate\Support\Facades\File;
session_start(); 


class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function quickview(Request $request)
    {
        $product_id = $request->product_id;
        $pro_qv = Product::find($product_id);
        
        $output['product_name'] = $pro_qv->product_name;
        $output['product_id'] = $pro_qv->product_id;
        $output['product_quantity'] = $pro_qv->product_quantity;
        $output['product_price'] = number_format($pro_qv->product_price,0,',','.'). 'VNĐ';
        $output['product_desc'] = $pro_qv->product_desc;
        $output['product_content'] = $pro_qv->product_content;
        $output['product_color'] = $pro_qv->product_color;
        $output['product_size']= $pro_qv->product_size;
        $output['product_image'] ='<p><img width="100%" src="uploads/product/'.$pro_qv->product_image.'"></p>';
        echo json_encode($output);
    }

    public function add_product(){
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->get();
        $brand_product = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get();
        return view('admin.product.add_product')->with('cate_product',$cate_product)->with('brand_product',$brand_product);
    }

    public function all_product(){
        $this->AuthLogin();
        $all_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->orderBy('tbl_product.product_id','desc')->paginate(5);
        $manager_product = view('admin.product.all_product')->with('all_product',$all_product);
        return view('admin_layout')->with('admin.product.all_product',$manager_product);
    }

    public function save_product(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['product_name']  = $request->product_name;
        $data['product_quantity']  = $request->product_quantity;
        $data['product_price']  = $request->product_price;
        $data['price_cost'] = $request->price_cost;
        $data['product_desc']  = $request->product_desc;
        $data['product_content']  = $request->product_content;
        $data['product_status']  = $request->product_status;
        $data['category_id']  = $request->product_cate;
        $data['brand_id']  = $request->product_brand;
        $data['product_size']  = $request->product_size;
        $data['product_color']  = $request->product_color;

        $path_pro = 'uploads/product/';
        $path_gal = 'uploads/gallery/';
        
        $get_image = $request->file('product_image');
        if ($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image -> move($path_pro,$new_image);
            File::copy($path_pro.$new_image,$path_gal.$new_image);
            $data['product_image'] = $new_image;
            
        }
        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();
        $gallery->gallery_image = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();

        Session::put('message','Thêm sản phẩm thành công');
        return Redirect::to('add-product');
    }

    public function unactive_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>1]);
        Session::put('message','Không kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function active_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->update(['product_status'=>0]);
        Session::put('message','Kích hoạt sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function edit_product($product_id){
        $this->AuthLogin();
        $cate_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand_product')->orderBy('brand_id','desc')->get(); 

        $edit_product = DB::table('tbl_product')->where('product_id',$product_id)->get();

        $manager_product  = view('admin.product.edit_product')->with('edit_product',$edit_product)
        ->with('cate_product',$cate_product)
        ->with('brand_product',$brand_product);

        return view('admin_layout')->with('admin.product.edit_product', $manager_product);
    }

     public function update_product(Request $request,$product_id){
        $this->AuthLogin();
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['product_quantity']  = $request->product_quantity;
        $data['product_price'] = $request->product_price;
        $data['price_cost'] = $request->price_cost;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['category_id'] = $request->product_cate;
        $data['brand_id'] = $request->product_brand;
        $data['product_status'] = $request->product_status;
        $data['product_size']  = $request->product_size;
        $data['product_color']  = $request->product_color;
        $get_image = $request->file('product_image');
        
        if($get_image){
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image)); //lấy phần đầu của hình ảnh >< end
                    $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                    $get_image->move('uploads/product',$new_image);
                    $data['product_image'] = $new_image;
                    DB::table('tbl_product')->where('product_id',$product_id)->update($data);
                    Session::put('message','Cập nhật sản phẩm thành công');
                    return Redirect::to('all-product');
        }
            
        DB::table('tbl_product')->where('product_id',$product_id)->update($data);
        Session::put('message','Cập nhật sản phẩm thành công');
        return Redirect::to('all-product');
    }

    public function delete_product($product_id){
        $this->AuthLogin();
        DB::table('tbl_product')->where('product_id',$product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công');
        return Redirect::to('all-product');
    }
    //End Function Product

    public function details_product($product_id){
        //slider
        $slider = Slider::orderby('slider_id','desc')->where('slider_status','1')->take(3)->get();
        
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')
        ->orderBy('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
        ->orderBy('brand_id','desc')->get(); 

        $details_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('tbl_product.product_id',$product_id)->get();

        foreach($details_product as $key => $value){
            $category_id = $value->category_id;
            $product_id = $value->product_id;
        }
        //gallery
        $gallery = Gallery::where('product_id',$product_id)->get();
        //lấy tất cả sản phẩm có cùng category_id trừ sản phẩm đã xuất hiện
        $related_product = DB::table('tbl_product')
        ->join('tbl_category_product','tbl_category_product.category_id','=','tbl_product.category_id')
        ->join('tbl_brand_product','tbl_brand_product.brand_id','=','tbl_product.brand_id')
        ->where('tbl_category_product.category_id',$category_id)
        ->whereNotIn('tbl_product.product_id',[$product_id])->get();

        return view('pages.sanpham.show_details')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('product_details',$details_product)->with('related',$related_product)->with('slider',$slider)
        ->with('gallery',$gallery);
    }

}
