<?php

namespace App\Infrastructure\Persistence\Eloquent\Category;

use App\Infrastructure\Persistence\Eloquent\Product\ProductModel;
use App\Infrastructure\Persistence\Eloquent\Stock\StockModel;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'category';
    protected $fillable = [
        'id',
        'product_id',
        'category',
        'created_at',
        'updated_at'
    ];

    /**
     * Relation with table Product.
     * **/
    public function product()
    {
        return $this->belongsTo(
            ProductModel::class,
            'product_id',
            'product_id'
        );
    }
    /**
     * Relation with table Stock through Product.
     * **/
    public function stock()
    {
        return $this->hasOneThrough(
            StockModel::class,
            ProductModel::class,
            'product_id',
            'product_id',
            'product_id',
            'product_id'
        );
    }
}
