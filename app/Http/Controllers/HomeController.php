<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Slider;
session_start(); 


class HomeController extends Controller
{

    public function index(Request $request){
        //slider
        $slider = Slider::orderby('slider_id','desc')->where('slider_status','1')->take(3)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')
        ->orderBy('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
        ->orderBy('brand_id','desc')->get(); 

        $all_product = DB::table('tbl_product')->where('product_status','0')
        ->orderBy('product_id','desc')->paginate(6);

        return view('pages.home')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('all_product',$all_product)->with('slider',$slider);

        //cách ngắn
        // return view('pages.home')->with(compact('cate_product','brand_product','all_product'));
    }

    public function search(Request $request)
    {
        $slider = Slider::orderby('slider_id','desc')->where('slider_status','1')->take(3)->get();
        $keysearch = $request->keywords;
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')
        ->orderBy('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
        ->orderBy('brand_id','desc')->get(); 

        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keysearch.'%')->get();

        return view('pages.sanpham.search')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('search_product',$search_product)->with('slider',$slider);
    }
}
 