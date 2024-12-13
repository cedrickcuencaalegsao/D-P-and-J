<?php

namespace App\Infrastructure\Persistence\Eloquent\Product;

use App\Infrastructure\Persistence\Eloquent\Category\CategoryModel;
use App\Infrastructure\Persistence\Eloquent\Sales\SalesModel;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $fillable = ['id', 'product_id', 'name', 'retrieve_price', 'retailed_price', 'image'];

    /**
     * Relation with table Category.
     * **/
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'product_id', 'product_id');
    }
    /**
     * Relation with table Sales.
     * **/
    // public function sales()
    // {
    //     return $this->hasOneThrough(
    //         SalesModel::class,
    //         CategoryModel::class,
    //         'product_id',
    //         'product_id',
    //         'product_id',
    //         'product_id',
    //     );
    // }
}
