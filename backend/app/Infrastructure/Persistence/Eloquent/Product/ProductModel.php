<?php

namespace App\Infrastructure\Persistence\Eloquent\Product;

use App\Infrastructure\Persistence\Eloquent\Category\CategoryModel;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $fillable = ['id', 'product_id', 'name', 'price', 'image', 'created_at', 'updated_at',];

    /**
     * Relation with table Category.
     * **/
    public function category()
    {
        return $this->hasOne(CategoryModel::class, 'product_id', 'product_id');
    }
}
