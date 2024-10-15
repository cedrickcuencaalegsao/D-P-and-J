<?php

namespace App\Infrastructure\Persistence\Eloquent\Stock;

use Illuminate\Database\Eloquent\Model;

class StockModel extends Model
{
    protected $table = 'stocks';
    protected $fillable = ['id', 'product_id', 'stocks', 'created_at', 'updated_at'];
}
