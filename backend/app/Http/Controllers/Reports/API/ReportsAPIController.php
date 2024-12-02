<?php

namespace App\Http\Controllers\Reports\API;

use App\Application\Sales\RegisterSales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsAPIController extends Controller
{
    private RegisterSales $registerSales;
    public function __construct(RegisterSales $registerSales)
    {
        $this->registerSales = $registerSales;
    }
    public function getSalesData()
    {
        $saleModel = $this->registerSales->findAll();
        return array_map(fn($saleModel) => $saleModel->toArray(), $saleModel);
    }
    public function getALL()
    {
        $data = ['sales' => $this->getSalesData()];
        return response()->json(compact('data'));
    }
}
