<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Order;
use App\Shipping;
use App\OrderDetails;
use App\Customer;
use App\Coupon;
use App\Product;
use App\Slider;
use App\Statistic;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
session_start(); 

class OrderController extends Controller
{
	public function cancel_order(Request $request)
	{
		$data = $request->all();
		$order = Order::where('order_code',$data['order_code'])->first();
		$order->order_destroy = $data['reason'];
		$order->order_status = 3;
		$order->save();
	}
	public function view_history_order($order_code)
	{
		if(!Session::get('customer_id')){
			return redirect('login-checkout')->with('error','Vui lòng đăng nhập để xem lịch sử đơn hàng');
		}else{
			$slider = Slider::orderby('slider_id','desc')->where('slider_status','1')->take(3)->get();
			$cate_product = DB::table('tbl_category_product')->where('category_status','0')
			->orderBy('category_id','desc')->get(); 
			$brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
			->orderBy('brand_id','desc')->get(); 

			//Xem lịch sử
			$order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
        	$getorder = Order::where('order_code',$order_code)->first();
			$customer_id = $getorder->customer_id;
			$shipping_id = $getorder->shipping_id;
			$order_status = $getorder->order_status;
        	
			$customer = Customer::where('customer_id',$customer_id)->first();
			$shipping = Shipping::where('shipping_id',$shipping_id)->first();

        	$order_details_product = OrderDetails::with('product')->where('order_code',$order_code)->get();

			//Lấy mã giảm giá
			foreach($order_details_product as $key => $ord_det){
				$product_coupon = $ord_det->product_coupon;
			}
		
			if($product_coupon!='No'){
				$coupon = Coupon::where('coupon_code',$product_coupon)->first();
				$coupon_condition = $coupon->coupon_condition;
				$coupon_number = $coupon->coupon_number;
			}else{
				$coupon_condition = 2;
				$coupon_number = 0;
			}
			
			return view('pages.history.view_history_order')->with('category',$cate_product)->with('brand',$brand_product)
			->with('slider',$slider)->with('getorder',$getorder)->with('order_details',$order_details)->with('customer',$customer)->with('shipping',$shipping)
			->with('coupon_condition',$coupon_condition)->with('coupon_number',$coupon_number)->with('order_status',$order_status);

		}
	}
	public function history()
	{
		if(!Session::get('customer_id')){
			return redirect('login-checkout')->with('error','Vui lòng đăng nhập để xem lịch sử đơn hàng');
		}else{
			$slider = Slider::orderby('slider_id','desc')->where('slider_status','1')->take(3)->get();
			$cate_product = DB::table('tbl_category_product')->where('category_status','0')
			->orderBy('category_id','desc')->get(); 
			$brand_product = DB::table('tbl_brand_product')->where('brand_status','0')
			->orderBy('brand_id','desc')->get(); 

			$get_order = Order::where('customer_id',Session::get('customer_id'))->orderby('order_date','desc')->paginate(2);

			return view('pages.history.history')->with('category',$cate_product)->with('brand',$brand_product)
			->with('slider',$slider)->with('get_order',$get_order);

		}
	}
	public function update_qty(Request $request)
	{
		$data = $request->all();
		$order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
		$order_details->product_sales_quantity = $data['order_qty'];
		$order_details->save();
	}
	public function update_order_qty(Request $request)
	{
		$data = $request->all();
		$order = Order::find($data['order_id']);
		$order->order_status = $data['order_status'];
		$order->save();
		//order date
		$order_date = $order->order_date;
		$statictis = Statistic::where('order_date',$order_date)->get();
		if($statictis){
			$statictis_count = $statictis->count();
		}else{
			$statictis_count = 0;
		}
		if($order->order_status==2){
			$total_order = 0;
			$sales = 0;
			$profit = 0;
			$quantity = 0;
			foreach($data['order_product_id'] as $key => $product_id){
				$product = Product::find($product_id);
				$product_quantity = $product->product_quantity;
				$product_sold = $product->product_sold;
				$product_price = $product->product_price;
				$product_cost = $product->price_cost;
				$now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

				foreach($data['quantity'] as $key2 => $qty){
					if($key==$key2){
						$pro_remain = $product_quantity - $qty; //còn lại
						$product->product_quantity = $pro_remain;
						$product->product_sold = $product_sold + $qty;
						$product->save();

						// update doanh thu
						$quantity+=$qty;
						$total_order+=1;
						$sales+=$product_price*$qty;
						$profit=$sales-($product_cost*$qty);
					}
				}
			}
			//update doanh so
			if($statictis_count>0){
				$statictis_update = Statistic::where('order_date',$order_date)->first();
				$statictis_update->sales = $statictis_update->sales + $sales;
				$statictis_update->profit = $statictis_update->profit + $profit;
				$statictis_update->quantity = $statictis_update->quantity + $quantity;
				$statictis_update->total_order = $statictis_update->total_order + $total_order;
				$statictis_update->save();
			}else{
				$statictis_update = new Statistic();
				$statictis_update->order_date = $order_date;
				$statictis_update->sales = $sales;
				$statictis_update->profit = $profit;
				$statictis_update->quantity = $quantity;
				$statictis_update->total_order = $total_order;
				$statictis_update->save();
			}
		}

	}
    public function print_order($checkout_code)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($checkout_code));
        return $pdf->stream();
    }

    public function print_order_convert($checkout_code)
    {
        $order_details = OrderDetails::where('order_code',$checkout_code)->get();
        $order = Order::where('order_code',$checkout_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code',$checkout_code)->get();
        
        foreach($order_details_product as $key => $order_d){
			$product_coupon = $order_d->product_coupon;
		}
        
		if($product_coupon != 'No'){
			$coupon = Coupon::where('coupon_code',$product_coupon)->first();

			$coupon_condition = $coupon->coupon_condition;
			$coupon_number = $coupon->coupon_number;

			if($coupon_condition==1){
				$coupon_echo = $coupon_number.'%';
			}elseif($coupon_condition==2){
				$coupon_echo = number_format($coupon_number,0,',','.').'đ';
			}
		}else{
			$coupon_condition = 2;
			$coupon_number = 0;

			$coupon_echo = '0';
		
		}

        $output = '';

		$output.='<style>body{
			font-family: DejaVu Sans;
		}
        i {
            float:right ;
        }
		p.p1{
			float:right ;
			margin-right: -90px;
		}
		h4.p1{
			float:right ;
			margin-right: 100px;
		}
		.table-styling{
			border:0.1 solid #000;
            text-align:center;
		}
		</style>
		<h2><center>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</center></h2>
		<h4><center>Độc lập - Tự do - Hạnh phúc</center></h4>
		<h4><center>---------------------------------</center></h4>
		<p><i>Hải Phòng, Ngày.....tháng.....năm.....</i></p><br>
		<h2><center>Tuấn Anh Store</center></h2>
		<p>Người đặt hàng:</p>
		<table border="0.1" class="table-styling">
				<thead>
					<tr>
						<th>Tên khách hàng</th>
						<th>Số điện thoại</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>';
				
		$output.='		
					<tr>
						<td>'.$customer->customer_name.'</td>
						<td>'.$customer->customer_phone.'</td>
						<td>'.$customer->customer_email.'</td>
						
					</tr>';
				

		$output.='				
				</tbody>	
		</table>

        <p>Ship hàng tới:</p>
			<table border="0.1" class="table-styling">
				<thead>
					<tr>
						<th>Tên người nhận</th>
						<th>Địa chỉ</th>
						<th>Sdt</th>
						<th>Email</th>
						<th>Ghi chú</th>
					</tr>
				</thead>
				<tbody>';
				
		$output.='		
					<tr>
						<td>'.$shipping->shipping_name.'</td>
						<td>'.$shipping->shipping_address.'</td>
						<td>'.$shipping->shipping_phone.'</td>
						<td>'.$shipping->shipping_email.'</td>
						<td>'.$shipping->shipping_note.'</td>
						
					</tr>';
				

		$output.='				
				</tbody>
			
		</table>

        <p>Đơn đặt hàng:</p>
			<table border="0.1" class="table-styling">
				<thead>
					<tr>
						<th>Tên sản phẩm</th>
						<th>Mã giảm giá</th>
						<th>Kích thước</th>
						<th>Màu sắc</th>
						<th>Số lượng</th>
						<th>Giá sản phẩm</th>
						<th>Phí ship</th>
						<th>Thành tiền</th>
					</tr>
				</thead>
				<tbody>';
                $total = 0;
				foreach($order_details_product as $key => $ord_d_p){ 
					$subtotal = $ord_d_p->product_price*$ord_d_p->product_sales_quantity;
					$total += $subtotal;
                    if($ord_d_p->product_coupon!='No'){
						$product_coupon = $ord_d_p->product_coupon;
					}else{
						$product_coupon = 'Không';
					}		

					$pro_size = '';
					if($ord_d_p->product_size==0){
						$pro_size = 'S';
					}elseif($ord_d_p->product_size==1){
						$pro_size = 'M';
					}elseif($ord_d_p->product_size==2){
						$pro_size = 'L';
					}elseif($ord_d_p->product_size==3){
						$pro_size = 'XL';
					}elseif($ord_d_p->product_size==4){
						$pro_size = 'M';
					}else{
						$pro_size = '';
					}
					
		$output.='		
				<tr>
                    <td>'.$ord_d_p->product_name.'</td>
                    <td>'.$ord_d_p->product_coupon.'</td>
                    <td>'.$pro_size.'</td>
                    <td>'.$ord_d_p->product_color.'</td>
                    <td>'.$ord_d_p->product_sales_quantity.'</td>
                    <td>'.number_format($ord_d_p->product_price,0,',','.').'đ'.'</td>
                    <td>'.number_format($ord_d_p->product_feeship,0,',','.').'đ'.'</td>
                    <td>'.number_format($subtotal,0,',','.').'đ'.'</td>
				</tr>';
                }
                if($coupon_condition==1){
					$total_after_coupon = ($total*$coupon_number)/100;
	                $total_coupon = $total - $total_after_coupon;
				}else{
                  	$total_coupon = $total - $coupon_number;
				}
        $output.= '<tr>
				<td colspan="3">
					<p>Mã giảm: '.$coupon_echo.'</p>
					<p>Phí ship: '.number_format($ord_d_p->product_feeship,0,',','.').'đ'.'</p>
					<p>Thanh toán: '.number_format($total_coupon + $ord_d_p->product_feeship,0,',','.').'đ'.'</p>
				</td>
		</tr>';
		$output.='				
				</tbody>
		</table>
			<table>
				<thead>
					<tr>
						<th></th>	
						<p class="p1">(Ký tên)</p><br><br>
						<h4 class="p1">Người lập đơn</h4>
					</tr>
				</thead>
				<tbody>';
						
		$output.='				
				</tbody>
			
		</table>
		';
		return $output;
    }

    public function view_order($order_code)
    {
        $order_details = OrderDetails::with('product')->where('order_code',$order_code)->get();
        $order = Order::where('order_code',$order_code)->get();
        foreach($order as $key => $ord){
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
			$order_status = $ord->order_status;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code',$order_code)->get();

        //Lấy mã giảm giá
        foreach($order_details_product as $key => $ord_det){
            $product_coupon = $ord_det->product_coupon;
        }
    
        if($product_coupon!='No'){
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }else{
            $coupon_condition = 2;
            $coupon_number = 0;
        }

        return view('admin.order.view_order')->with(compact('order_details','customer','shipping','coupon_condition','coupon_number','order','order_status')); 
    }

    public function manage_order()
    {
        $order = Order::orderby('order_id','desc')->paginate(5);//phân chia 1 trang là 5 
        return view('admin.order.manage_order')->with(compact('order')); 
    }
}
