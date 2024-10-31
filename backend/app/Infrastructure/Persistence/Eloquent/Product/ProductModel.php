<?php

namespace App\Infrastructure\Persistence\Eloquent\Product;

use App\Infrastructure\Persistence\Eloquent\Category\CategoryModel;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $fillable = ['id', 'name', 'price', 'created_at', 'updated_at'];

    public function category()
    {
        return $this->hasOne(CategoryModel::class, 'product_id', 'product_id');
    }
}
