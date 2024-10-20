<?php

namespace App\Http\Controllers\Stocks\API;

use App\Domain\Stock\StockRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StocksAPIController extends Controller
{
    private StockRepository $stockRepository;
    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }
    public function getAll()
    {
        $stockModel = $this->stockRepository->findAll();
        $stocks = array_map(fn($stockModel) => $stockModel->toArray(), $stockModel);
        return response()->json(compact('stocks'), 200);
    }
}
