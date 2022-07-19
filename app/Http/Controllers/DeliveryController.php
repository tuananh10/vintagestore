<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\City;
use App\Province;
use App\Ward;
use App\Feeship;
session_start();

class DeliveryController extends Controller
{
    
    public function update_delivery(Request $request)
    {
        $data = $request->all();
        $fee_ship = Feeship::find($data['feeship_id']);
        $fee_value = rtrim($data['fee_value'],'.');
        $fee_ship->fee_feeship = $fee_value;
        $fee_ship->save();
    }
    public function select_feeship()
    {
        $feeship = Feeship::orderby('fee_id','DESC')->get();
		$output = '';
		$output .= '<div class="table-responsive">  
			<table class="table table-bordered">
				<thead> 
					<tr>
						<th>Tên thành phố</th>
						<th>Tên quận huyện</th> 
						<th>Tên xã phường</th>
						<th>Phí ship</th>
					</tr>  
				</thead>
				<tbody>
				';

				foreach($feeship as $key => $fee){

				$output.='
					<tr>
						<td>'.$fee->city->name_city.'</td>
						<td>'.$fee->province->name_province.'</td>
						<td>'.$fee->ward->name_ward.'</td>
						<td contenteditable data-feeship_id="'.$fee->fee_id.'" class="fee_feeship_edit">'.number_format($fee->fee_feeship,0,',','.').'</td>
					</tr>
					';
				}

				$output.='		
				</tbody>
				</table></div>
				';

				echo $output;
    }
    public function insert_delivery(Request $request)
    {
        $data = $request->all();
		$fee_ship = new Feeship();
		$fee_ship->fee_matp = $data['city'];
		$fee_ship->fee_maqh = $data['province'];
		$fee_ship->fee_xaid = $data['ward'];
		$fee_ship->fee_feeship = $data['fee_ship'];
		$fee_ship->save();
    }
    public function delivery()
    {
        $city = City::orderby('matp','asc')->get();
        return view('admin.delivery.add_delivery')->with(compact('city'));
    }
    public function select_delivery(Request $request)
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
}
