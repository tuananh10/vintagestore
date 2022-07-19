<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\City;
use App\Province;
use App\Ward;
use App\Feeship;
use App\Order;
use App\Shipping;
use App\OrderDetails;
use App\Slider;
use Carbon\Carbon;

session_start(); 

class CheckoutController extends Controller
{

    public function confirm_order(Request $request)
    {
        $data = $request->all();
        $shipping = new Shipping();
        $shipping->shipping_name = $data['shipping_name'] ;
        $shipping->shipping_email = $data['shipping_email'] ;
        $shipping->shipping_phone = $data['shipping_phone'] ;
        $shipping->shipping_address = $data['shipping_address'] ;
        $shipping->shipping_method = $data['shipping_method'] ;
        $shipping->shipping_note = $data['shipping_note'] ;
        $shipping->save();
        //Lấy ra id vừa tạo cho vào order
        $shipping_id = $shipping->shipping_id;

        $code_order = substr(md5(microtime()),rand(0,26),5);

        $order = new Order();
        $order->customer_id = Session::get('customer_id');
        $order->shipping_id = $shipping_id;
        $order->order_status = 1;
        $order->order_code = $code_order;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $order->created_at = $today;
        $order->order_date = $order_date;
        $order->save();


        if(Session::get('cart')==true){
            foreach(Session::get('cart') as $key => $cart){

                $order_details = new OrderDetails();
                $order_details->order_code = $code_order;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_size = $cart['product_size'];
                $order_details->product_color = $cart['product_color'];
                $order_details->product_coupon = $data['order_coupon'];
                $order_details->product_feeship = $data['order_fee'];
                $order_details->save();
            }
        }
        Session::forget('coupon');
        Session::forget('fee');
        Session::forget('cart');
        Session::forget('success_paypal');
        Session::forget('total_paypal');
    }

    public function delete_fee()
    {
        Session::forget('fee');
        return redirect()->back();
    }

    public function calculate_fee(Request $request)
    {
        $data = $request->all();
        if($data['matp']){
            $feeship = Feeship::where('fee_matp',$data['matp'])->where('fee_maqh',$data['maqh'])
            ->where('fee_xaid',$data['xaid'])->get();
            if($feeship){
                $count_feeship = $feeship->count();
                if($count_feeship>0){
                    foreach($feeship as $key => $fee){
                        Session::put('fee',$fee->fee_feeship);
                        Session::save();
                    }
            }else{
                Session::put('fee',30000);
                Session::save();
            }
            
            }
        }
    }
    public function select_delivery_home(Request $request)
    {
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=='city'){
                $select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','asc')->get();
                $output.='<option>---Chọn quận/huyện---</option>';
                foreach($select_province as $key => $province){
                //nối
                $output .='<option value="'.$province->maqh.'">'.$province->name_province.'</option>';
                }
            }else{
                $select_ward = Ward::where('maqh',$data['ma_id'])->orderby('xaid','asc')->get();
                $output.='<option>---Chọn xã/phường---</option>';
                foreach($select_ward as $key => $ward){
                //nối
                $output .='<option value="'.$ward->xaid.'">'.$ward->name_ward.'</option>';
                }
            }
        echo $output;
        }
    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function login_checkout(){
        $slider = Slider::orderby('slider_id','desc')->where('slider_status','1')->take(3)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')
        ->orderBy('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
        ->orderBy('brand_id','desc')->get(); 
        return view('pages.checkout.login_checkout')->with('category',$cate_product)->with('brand',$brand_product)->with('slider',$slider);
    }

    public function add_customer(Request $request)
    {
        $data=array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;

        //lấy id của cái data vừa thêm vào
        $customer_id = DB::table('tbl_customer')->insertGetId($data);

        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);
        return Redirect::to('/checkout');

    }

    public function checkout()
    {
        $slider = Slider::orderby('slider_id','desc')->where('slider_status','1')->take(3)->get();
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')
        ->orderBy('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
        ->orderBy('brand_id','desc')->get(); 
        $city = City::orderby('matp','asc')->get();
        return view('pages.checkout.show_checkout')->with('category',$cate_product)->with('brand',$brand_product)
        ->with('city',$city)->with('slider',$slider);
    }

    public function save_checkout_customer(Request $request)
    {
        $data=array();
        $data['shipping_name'] = $request->shipping_name;
        $data['shipping_email'] = $request->shipping_email;
        $data['shipping_phone'] = $request->shipping_phone;
        $data['shipping_address'] = $request->shipping_address;
        $data['shipping_note'] = $request->shipping_note;

        //lấy id của cái data vừa thêm vào
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data);

        Session::put('shipping_id',$shipping_id);

        return Redirect::to('/payment');
    }

    public function payment()
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')
        ->orderBy('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
        ->orderBy('brand_id','desc')->get(); 
        return view('pages.checkout.payment')->with('category',$cate_product)->with('brand',$brand_product);
    }

    public function logout_checkout()
    {
        Session::flush();
        return Redirect::to('/login-checkout');
    }

    public function login_customer(Request $request)
    {
        $email = $request->email_account;
        $password = md5($request->pass_account);
        $result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$password)->first();
        Session::put('customer_id',$result->customer_id);
        
        if($result){
            return Redirect::to('/');
        }else{
            return Redirect::to('/login-checkout');

        }

    }

}
