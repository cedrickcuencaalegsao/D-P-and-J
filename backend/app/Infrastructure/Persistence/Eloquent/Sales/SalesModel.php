<?php

namespace App\Infrastructure\Persistence\Eloquent\Sales;

use App\Infrastructure\Persistence\Eloquent\Category\CategoryModel;
use App\Infrastructure\Persistence\Eloquent\Product\ProductModel;
use Illuminate\Database\Eloquent\Model;

class SalesModel extends Model
{
    protected $table = 'sales';
    protected $fillable = [
        'id',
        'product_id',
        'item_sold',
        'retailed_price',
        'retrieve_price',
        'total_sales',
        'created_at',
        'updated_at'
    ];
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'product_id');
    }
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
