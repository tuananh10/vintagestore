<?php

namespace App\Http\Controllers;
use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
session_start(); 

class SliderController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function unactive_slide($slider_id){
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>0]);
        Session::put('message','Không kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('manage-slider');
    }

    public function active_slide($slider_id){
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>1]);
        Session::put('message','Kích hoạt thương hiệu sản phẩm thành công');
        return Redirect::to('manage-slider');
    }

    public function manage_slider()
    {   
        $all_slide = Slider::orderby('slider_id','desc')->get();
        return view('admin.slider.list_slider')->with(compact('all_slide'));
    }

    public function add_slider()
    {
        return view('admin.slider.add_slider');
        
    }
    public function insert_slider(Request $request)
    {
        $data = $request->all();
        $this->AuthLogin();

        $get_image = $request->file('slider_image');
        
        if($get_image){
                    $get_name_image = $get_image->getClientOriginalName();
                    $name_image = current(explode('.',$get_name_image)); //lấy phần đầu của hình ảnh >< end
                    $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension(); 
                    $get_image->move('uploads/slider',$new_image);
                    
                    $slider = new Slider();
                    $slider->slider_name = $data['slider_name'];
                    $slider->slider_image = $new_image;
                    $slider->slider_status = $data['slider_status'];
                    $slider->slider_desc = $data['slider_desc'];
                    $slider->save();

                    Session::put('message','Thêm slider thành công');
                    return Redirect::to('add-slider');
        }else{
            Session::put('message','Làm ơn thêm hình ảnh');
            return Redirect::to('add-slider');
        }

    }
}
