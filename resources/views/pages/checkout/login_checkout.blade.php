@extends('layout')
@section('content')

<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4 col-sm-offset-1">
                <div class="login-form"><!--login form-->
                    <h2>Đăng nhập tài khoản</h2>
                    <form action="{{URL::to('/login-customer')}}" method="POST">
                        @csrf
                        <input type="text" name="email_account" placeholder="Tài khoản" />
                        <input type="password" name="pass_account" placeholder="Mật khẩu" />
                        <span>
                            <input type="checkbox" class="checkbox"> 
                            Ghi nhớ đăng nhập 
                        </span>
                        <button type="submit" class="btn btn-default">Đăng nhập</button>
                    </form>
                    <ul>
                        <li style="margin-right: 40px">
                            <a href="{{url('/login-facebook')}}" class="btn btn-default" style="width: 100%">
                            <img src="{{asset('frontend/images/fb.png')}}" alt="" height="30" width="30"> Đăng nhập bằng facebook</a>
                        </li>
                        <br/>
                        <li style="margin-right: 40px">
                            <a href="{{url('/login-google')}}" class="btn btn-default " style="width: 100%">
                            <img src="{{asset('frontend/images/gg.png')}}" alt="" height="30" width="30"> Đăng nhập bằng google    .</a>
                        </li>
                    </ul>
                </div><!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">Hoặc</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form"><!--sign up form-->
                    <h2>Đăng ký</h2>
                    <form action="{{URL::to('/add-customer')}}" method="POST">
                        @csrf
                        <input type="text" name="customer_name" placeholder="Họ và tên"/>
                        <input type="email" name="customer_email" placeholder="Địa chỉ Email"/>
                        <input type="password" name="customer_password" placeholder="Mật khẩu"/>
                        <input type="text" name="customer_phone" placeholder="Điện thoại"/>
                        <button type="submit" class="btn btn-default">Đăng ký</button>
                    </form>
                </div><!--/sign up form-->
            </div>
        </div>
    </div>
</section><!--/form-->

@endsection