<?php

namespace App\Infrastructure\Persistence\Eloquent\Product;

use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $fillable = ['id', 'name', 'price', 'created_at', 'updated_at'];
}
