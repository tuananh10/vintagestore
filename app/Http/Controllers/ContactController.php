<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Slider;
session_start(); 

class ContactController extends Controller
{
    public function update_info(Request $request,$info_id)
    {
        $data = $request->all();
        $contact = Contact::find($info_id);
        $contact->info_contact = $data['info_contact'];
        $contact->info_map = $data['info_map'];
        $contact->info_fanpage = $data['info_fanpage'];
        $get_image = $request->file('info_logo');
        $path = 'uploads/contact';
        if($get_image){
            unlink($path.$contact->info_logo);
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image -> move($path,$new_image);
            
            $contact->info_logo = $new_image;
        }
        $contact->save();
        return redirect()->back()->with('message','Thêm thông tin thành công');
    }
    public function save_info(Request $request)
    {
        $data = $request->all();
        $contact = new Contact();
        $contact->info_contact = $data['info_contact'];
        $contact->info_map = $data['info_map'];
        $contact->info_fanpage = $data['info_fanpage'];
        $get_image = $request->file('info_logo');
        $path = 'uploads/contact';
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image -> move($path,$new_image);
            
            $contact->info_logo = $new_image;
        }
        $contact->save();
        return redirect()->back()->with('message','Thêm thông tin thành công');
    }
    public function information()
    {
        $contact = Contact::where('info_id',2)->get();
        return view('admin.information.update_information')->with('contact',$contact);
    }
    public function lien_he(Request $request)
    {
        $slider = Slider::orderby('slider_id','desc')->where('slider_status','1')->take(3)->get();
        $keysearch = $request->keywords;
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')
        ->orderBy('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
        ->orderBy('brand_id','desc')->get(); 
        $contact = Contact::where('info_id',2)->get();

        return view('pages.contact.contact')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('slider',$slider)->with('contact',$contact);
    }
}
