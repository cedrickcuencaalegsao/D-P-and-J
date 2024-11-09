<?php

namespace App\Infrastructure\Persistence\Eloquent\Category;

use App\Infrastructure\Persistence\Eloquent\Product\ProductModel;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'category';
    protected $fillable = ['id', 'product_id', 'category', 'created_at', 'updated_at'];

}
