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
    /**
     * Get all stocks data.
     * **/
    public function getAll()
    {
        $stockModel = $this->stockRepository->findAll();
        $stocks = array_map(fn($stockModel) => $stockModel->toArray(), $stockModel);
        return response()->json(compact('stocks'), 200);
    }
    /**
     * Buy a product.
     * **/
    public function buyProduct(Request $request)
    {
        $stockModel = $this->stockRepository->findByProductID(
            $request->product_id
        );
        if (!$stockModel || $stockModel->getStocks() <= 0) {
            return response()->json(["message" => "Invalid product ID. Please Restock the product first."], 404);
        }
        $this->stockRepository->buyProduct($request->product_id, $request->quantity);
        return response()->json(["message" => "Product bought successfully"], 200);
    }
    /**
     * Restock a product.
     * **/
    public function reStocks(Request $request)
    {
        $stockModel = $this->stockRepository->findByProductID(
            $request->product_id
        );
        if (!$stockModel) {
            return response()->json(["message" => "Invalid product ID. Please Restock the product first."], 404);
        }
        $this->stockRepository->reStocks($request->product_id, $request->quantity);
        return response()->json(["message" => "Product restocked successfully"], 200);
    }
}
