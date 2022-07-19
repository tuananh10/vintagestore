<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'customert_email',  'customer_password',  'customer_name','customer_phone'
    ];
    protected $primaryKey = 'customer_id';
 	protected $table = 'tbl_customer';

}