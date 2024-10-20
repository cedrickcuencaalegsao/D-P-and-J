<?php

namespace App\Http\Controllers\Sales\API;

use App\Domain\Sale\SaleRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesAPIController extends Controller
{
    private SaleRepository $saleRepository;
    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }
    public function getAll()
    {
        $saleModel = $this->saleRepository->findAll();
        $sales = array_map(fn($saleModel) => $saleModel->toArray(), $saleModel);
        return response()->json(compact('sales'));
    }
}
