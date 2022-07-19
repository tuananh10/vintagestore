<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Social;
use Illuminate\Support\Facades\Session;
use App\Login;
use Illuminate\Support\Facades\DB;

session_start();

class LoginController extends Controller
{
    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
   
    public function callback_google(){
        $users = Socialite::driver('google')->user(); 
        $authUser = $this->findOrCreateUser($users,'google');
        $account_name = Login::where('customer_id',$authUser->user)->first();
        Session::put('customer_name',$account_name->customer_name);
        Session::put('customer_id',$account_name->customer_id);
        return redirect('/')->with('message', 'Đăng nhập thành công');
      
       
    }
    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        
        if($authUser){

            return $authUser;
        };
        

        $orang = Login::where('customer_email',$users->email)->first();

            if(!$orang){
                $orang = DB::table('tbl_customer')->insert([
                    'customer_name' => $users->name,
                    'customer_email' => $users->email,
                    'customer_password' => '',
                    'customer_phone' => '',
                ]);
              
            }
            $id = DB::table('tbl_customer')->where('customer_email',$users->email)->first()->customer_id;
            $customer = new Social([
                'provider_user_id' => $users->id,
                'provider' => 'google',
                'user' => $id,
            ]);
        $customer->save();
        $customer->login()->associate($orang);
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        };
        
    }
}
