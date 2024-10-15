<?php

namespace App\Infrastructure\Persistence\Eloquent\Sales;

use Illuminate\Database\Eloquent\Model;

class SalesModel extends Model
{
    protected $table = 'sales';
    protected $fillable = ['id', 'product_id', 'total_sales', 'created_at', 'updated_at'];
}
