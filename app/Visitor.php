<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'ip_address', 'date_access'
    ]; 
    protected $primaryKey = 'visitor_id';
    protected $table = 'tbl_visitors';
}
