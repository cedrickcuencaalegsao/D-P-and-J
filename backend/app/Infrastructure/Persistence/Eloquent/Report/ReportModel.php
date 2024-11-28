<?php

namespace App\Infrastructure\Persistence\Eloquent\Report;

use App\Infrastructure\Persistence\Eloquent\Product\ProductModel;
use App\Infrastructure\Persistence\Eloquent\Sales\SalesModel;
use Illuminate\Database\Eloquent\Model;

class ReportModel extends Model
{
    protected $table = 'reports';
    protected $fillable = ['id', 'product_id', 'report', 'created_at', 'updated_at'];
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'product_id');
    }
    public function sale()
    {
        return $this->hasOneThrough(
            SalesModel::class,
            ProductModel::class,
            'product_id',
            'product_id',
            'product_id',
            'product_id',
        );
    }
}
