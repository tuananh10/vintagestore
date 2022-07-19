<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Gallery;
session_start(); 

class GalleryController extends Controller
{
    public function update_gallery(Request $request)
    {
        $get_image = $request->file('file');
        $gal_id = $request->gal_id;
        if($get_image){
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
                $get_image -> move('uploads/gallery',$new_image);
                $gallery = Gallery::find($gal_id);
                unlink('uploads/gallery/'.$gallery->gallery_image);
                $gallery->gallery_image = $new_image;   
                $gallery->save(); 
            }

    }
    public function delete_gallery(Request $request)
    {
        $gal_id = $request->gal_id;
        $gallery = Gallery::find($gal_id);
        unlink('uploads/gallery/'.$gallery->gallery_image);
        $gallery->delete();
    }
    public function update_gallery_name(Request $request)
    {
        $gal_id = $request->gal_id;
        $gal_text = $request->gal_text;
        $gallery = Gallery::find($gal_id);
        $gallery->gallery_name = $gal_text;
        $gallery->save(); 
    }
    public function insert_gallery(Request $request,$prod_id)
    {
        $get_image = $request->file('file');
        if($get_image){
            foreach($get_image as $img){
                $get_name_image = $img->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image = $name_image.rand(0,99).'.'.$img->getClientOriginalExtension();
                $img -> move('uploads/gallery',$new_image);
                $gallery = new Gallery();
                $gallery->gallery_name = $new_image;
                $gallery->gallery_image = $new_image;
                $gallery->product_id = $prod_id;
                $gallery->save(); 
            }
        }
        Session::put('message','Thêm thư viện ảnh thành công');
        return redirect()->back();
    }
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function add_gallery($product_id)
    {
        $prod_id = $product_id;
        return view('admin.gallery.add_gallery')->with(compact('prod_id'));
    }
    public function select_gallery(Request $request)
    {
        $product_id = $request->prod_id;
        $gallery = Gallery::where('product_id',$product_id)->get();
        $gallery_count = $gallery->count();
        $output = '
        <form>
            '.csrf_field().'
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên hình ảnh</th>
                <th scope="col">Hình ảnh</th>
                <th scope="col">Quản lý</th>
            </tr>
            </thead>
            <tbody>
        ';
        if($gallery_count>0){
            $i=0;
            foreach($gallery as $key => $gal){
                $i++;
                $output .='
                <tr>
                    <td scope="row">'.$i.'</td>
                    <td contenteditable class="edit_gal_name" data-gal_id="'.$gal->gallery_id.'">
                    '.$gal->gallery_name.'</td>
                    <td>
                        <img src="'.url('uploads/gallery/'.$gal->gallery_image).'"
                        class="img-thumbnail" width="120" height="120">
                        
                        <input type="file" style="width:40%" data-gal_id="'.$gal->gallery_id.'"
                        id="file-'.$gal->gallery_id.'" name="file" accept="image/*" class="file_image">
                    </td>               
                    <td>
                        <button type="button" data-gal_id="'.$gal->gallery_id.'" 
                        class="btn btn-xs btn-danger delete-gallery ">Xóa</button>
                    </td>
                </tr>
            ';
        }
        }else{
            $output .='
                <tr>
                    <td colspan="4">Sản phẩm này chưa có thư viện ảnh</td>
                </tr>
            ';
        }
        $output .='
            </tbody>
            </table>
            </form>
        ';
        echo $output;
    }
}
