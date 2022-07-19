<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\LoginAdmin;
use App\Order;
use App\Product;
use App\Visitor;
use Carbon\Carbon;

session_start();

class AdminController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
        return view ('admin_login');
    }
    public function show_dashboard(Request $request){
        $this->AuthLogin();
        //get ip
        $user_ip_address = $request->ip();
        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        
        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $oneyear = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        
        //total last month
        $visitor_of_lastmonth = Visitor::whereBetween('date_access',[$early_last_month,$end_of_last_month])->get();
        $visitor_lastmonth_count = $visitor_of_lastmonth->count();

        //total this month
        $visitor_of_thismonth = Visitor::whereBetween('date_access',[$early_this_month,$now])->get();
        $visitor_thismonth_count = $visitor_of_thismonth->count();

        //total year
        $visitor_of_year = Visitor::whereBetween('date_access',[$oneyear,$now])->get();
        $visitor_year_count = $visitor_of_year->count();

        //current online
        $visitor_current = Visitor::where('ip_address',$user_ip_address)->get();
        $visitor_count = $visitor_current->count();

        if($visitor_count<1){
            $visitor = new Visitor();
            $visitor->ip_address = $user_ip_address;
            $visitor->date_access = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
            $visitor->save();
        }

        //total visitors
        $visitors = Visitor::all();
        $visitors_total = $visitors->count();

        //total
        $app_product = Product::all()->count();
        $app_order = Order::all()->count();
        $app_customer = Customer::all()->count();
        return view ('admin.dashboard')->with(compact('visitors_total','visitor_count','visitor_year_count',
        'visitor_thismonth_count','visitor_lastmonth_count','app_product','app_order','app_customer'));
    }
    public function dashboard(Request $request){
        $data = $request->all(); 
        $admin_email =$data['admin_email'];
        $admin_password = md5($data['admin_password']);

        $login = LoginAdmin::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($login){
            $login_count = $login->count();
            if($login_count>0){
                Session::put('admin_name',$login->admin_name);
                Session::put('admin_id',$login->admin_id);
                return Redirect::to('/dashboard');
            }
        }else{
            Session::put('message','Mật khẩu hoặc tài khoản bị sai.Làm ơn nhập lại');
            return Redirect::to('/admin');
        }
    }

    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    } 
}
