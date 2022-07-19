<?php

namespace App\Http\Controllers;

use App\Statistic;
use Carbon\Carbon;
use App\Visitor;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function days_order(Request $request)
    {
        $sub60days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(60)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistic::whereBetween('order_date',[$sub60days,$now])->orderBy('order_date','asc')->get();
        
        foreach($get as $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
    public function filter_by_date(Request $request)
    {
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        
        $get = Statistic::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','asc')->get();

        foreach($get as $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
    public function dashboard_filter(Request $request)
    {
        $data = $request->all();
        // echo $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H-i-s');

        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $subnam = Carbon::now('Asia/Ho_Chi_Minh')->subMonths(12)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        
        if($data['dashboard_value']=='7ngay'){

            $get = Statistic::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','asc')->get();
       
        }else if($data['dashboard_value']=='thangnay'){

            $get = Statistic::whereBetween('order_date',[$dauthangnay,$now])->orderBy('order_date','asc')->get();
       
        }else if($data['dashboard_value']=='thangtruoc'){

            $get = Statistic::whereBetween('order_date',[$dau_thangtruoc,$cuoi_thangtruoc])->orderBy('order_date','asc')->get();
        
        }else {
            $get = Statistic::whereBetween('order_date',[$subnam,$now])->orderBy('order_date','asc')->get();
        }

        foreach($get as $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart_data);
    }
}
