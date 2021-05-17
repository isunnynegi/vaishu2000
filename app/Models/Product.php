<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table ="product";
    protected $fillable =[
        'name','category_id','description','status','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];
}
