<?php

namespace App\Infrastructure\Persistence\Eloquent\Stock;

use App\Infrastructure\Persistence\Eloquent\Category\CategoryModel;
use App\Infrastructure\Persistence\Eloquent\Product\ProductModel;
use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    protected $table = 'stocks';
    protected $fillable = ['id', 'product_id', 'stocks', 'created_at', 'updated_at'];
    /**
     * Relationship with products.
     * **/
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'product_id');
    }
    /**
     * Relationship with category.
     * **/
    public function category()
    {
        return $this->hasOneThrough(
            CategoryModel::class,
            ProductModel::class,
            'product_id',
            'product_id',
            'product_id',
            'product_id',
        );
    }
}
