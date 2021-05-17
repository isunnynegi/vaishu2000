<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    use HasFactory;
    protected $table ="category";
    
    protected $fillable = [
        'name','type','status','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];    
}