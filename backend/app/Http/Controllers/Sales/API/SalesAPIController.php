<?php

namespace App\Http\Controllers\Sales\API;

use App\Application\Sales\RegisterSales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesAPIController extends Controller
{
    private RegisterSales $registerSales;
    public function __construct(RegisterSales $registerSales)
    {
        $this->registerSales = $registerSales;
    }
    public function getAll()
    {
        $saleModel = $this->registerSales->findAll();
        $data = array_map(fn($saleModel) => $saleModel->toArray(), $saleModel);
        return response()->json(compact('data'));
    }
}
