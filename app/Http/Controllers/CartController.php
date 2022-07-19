<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Gloudemans\Shoppingcart\Facades\Cart as FacadesCart;
use App\Slider;
session_start(); 

class CartController extends Controller
{
    public function show_cart_update()
    {
        $cart = count(Session::get('cart'));
        $output = '';
        $output.='<span class="badges">'.$cart.'</span>';
        echo $output;
    }
    public function delete_all_product(){
        $cart = Session::get('cart');
        if($cart == true){
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back()->with('Xóa tất cả sản phẩm thành công');
        }
    }
    public function update_cart_ajax(Request $request){
        $data = $request->all();
        $cart = Session::get('cart');
        if ($cart == true){
            $message = '';
            foreach($data['cart_qty'] as $key =>$qty){
                foreach($cart as $session =>$val){
                    if($val['session_id']==$key && $qty<=$cart[$session]['product_quantity']){
                        $cart[$session]['product_qty'] = $qty;
                        $message.='<p style="color:blue">Cập nhật số lượng :'.$cart[$session]['product_name'].' thành công</p>';
                    }elseif($val['session_id']==$key && $qty>$cart[$session]['product_quantity']){
                        $message.='<p style="color:red">Cập nhật số lượng :'.$cart[$session]['product_name'].' thất bại</p>';
                    }
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message',$message);

        }else{
            return Redirect()->back()->with('message','Xóa sản phẩm thành công');
        }
    }
    
    public function delete_pro_ajax($session_id){
        $cart = Session::get('cart');
        if($cart ==true){
            foreach($cart as $key => $val_del){
                if($val_del['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            Session::put('cart',$cart);
            return Redirect()->back()->with('message','Xóa sản phẩm thành công');
        }else{
            return Redirect()->back()->with('message','Xóa sản phẩm thất bại');
        }
    }
    public function gio_hang(Request $request){
        $slider = Slider::orderby('slider_id','desc')->where('slider_status','1')->take(3)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')
        ->orderBy('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
        ->orderBy('brand_id','desc')->get(); 
        
        return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider);
    }
    public function add_cart_ajax(Request $request)
    {
        $data = $request->all();
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
            $is_available = 0;
            foreach($cart as $key =>$val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_available ++; 
                }
            }
            if($is_available==0){
                $cart[] = array(
                    'session_id'=> $session_id,
                    'product_name'=> $data['cart_product_name'],
                    'product_quantity'=> $data['cart_product_quantity'],
                    'product_id'=> $data['cart_product_id'],
                    'product_image'=> $data['cart_product_image'],
                    'product_price'=> $data['cart_product_price'],
                    'product_qty'=> $data['cart_product_qty'],
                    'product_size'=> $data['cart_product_size'],
                    'product_color'=> $data['cart_product_color']
                );
                Session::put('cart',$cart);
            }
        }else{
            $cart[] = array(
                'session_id'=> $session_id,
                'product_name'=> $data['cart_product_name'],
                'product_quantity'=> $data['cart_product_quantity'],
                'product_id'=> $data['cart_product_id'],
                'product_image'=> $data['cart_product_image'],
                'product_price'=> $data['cart_product_price'],
                'product_qty'=> $data['cart_product_qty'],
                'product_size'=> $data['cart_product_size'],
                'product_color'=> $data['cart_product_color']
            );
        Session::put('cart',$cart);
        }
        Session::save();
    }
    public function save_cart(Request $request)
    {
        
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id',$productId)->first(); 

        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;
        $data['options']['color'] = $product_info->product_color;
        $data['options']['size'] = $product_info->product_size;
        FacadesCart::add($data);
        FacadesCart::setGlobalTax(10);

        return Redirect::to('/show-cart');

    }

    public function show_cart()
    {   
        $slider = Slider::orderby('slider_id','desc')->where('slider_status','1')->take(3)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')
        ->orderBy('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
        ->orderBy('brand_id','desc')->get(); 
        
        return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider);
    }

    public function delete_to_cart($rowId){
        FacadesCart::update($rowId,0);
        return Redirect::to('/show-cart');
    }

    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        FacadesCart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }

}
