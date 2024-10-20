<?php

namespace App\Infrastructure\Persistence\Eloquent\Report;

use Illuminate\Database\Eloquent\Model;

class ReportModel extends Model
{
    protected $table = 'reports';
    protected $fillable = ['id', 'product_id', 'report', 'created_at', 'updated_at'];
}
