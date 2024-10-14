<?php

namespace App\Infrastructure\Persistence\Eloquent\Category;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table = 'category';
    protected $fillable = ['id', 'product_id', 'category', 'created_at', 'update_at'];
}
