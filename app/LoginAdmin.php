<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAdmin extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'admin_email',  'admin_password',  'admin_name','admin_phone'
    ];
    protected $primaryKey = 'admin_id';
 	protected $table = 'tbl_admin';
}
