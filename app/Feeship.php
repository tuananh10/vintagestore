<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    public $timestamps = false; 
    protected $fillable = [
    	'fee_matp', 'fee_maqh','fee_xaid','fee_feeship'
    ];
    protected $primaryKey = 'fee_id';
 	protected $table = 'tbl_feeship';

 	public function city(){
 		return $this->belongsTo('App\City', 'fee_matp');
 	}
 	public function province(){
 		return $this->belongsTo('App\Province', 'fee_maqh');
 	}
 	public function ward(){
 		return $this->belongsTo('App\Ward', 'fee_xaid');
 	}
}
