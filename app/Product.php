<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'product_name', 'category_id', 'brand_id','product_desc','product_content', 
          'product_price','product_image','price_cost','product_size','product_color','product_status'
    ];

    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';
}
