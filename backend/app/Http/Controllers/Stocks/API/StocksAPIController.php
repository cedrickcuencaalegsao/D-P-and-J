<?php

namespace App\Http\Controllers\Stocks\API;

use App\Application\Stock\RegisterStock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StocksAPIController extends Controller
{
    private RegisterStock $registerStock;
    public function __construct(RegisterStock $registerStock)
    {
        $this->registerStock = $registerStock;
    }
    /**
     * Get all stocks data.
     * **/
    public function getAll()
    {
        $stockModel = $this->registerStock->findAll();
        $stocks = array_map(fn($stockModel) => $stockModel->toArray(), $stockModel);
        return response()->json(compact('stocks'), 200);
    }
    /**
     * Buy a product.
     * **/
    public function buyProduct(Request $request)
    {
        $stockModel = $this->registerStock->findByProductID(
            $request->product_id
        );
        if (!$stockModel || $stockModel->getStocks() <= 0) {
            return response()->json(["message" => "Invalid product ID. Please Restock the product first."], 404);
        }
        $this->registerStock->buyProduct($request->product_id, $request->quantity);
        return response()->json(["message" => "Product bought successfully"], 200);
    }
    /**
     * Restock a product.
     * **/
    public function reStocks(Request $request)
    {
        // $data = $request->all();
        // return response()->json(compact("data"), 200);
        $stockModel = $this->registerStock->findByProductID(
            $request->product_id
        );
        if (!$stockModel) {
            return response()->json(["message" => "Invalid product ID. Please Restock the product first."], 404);
        }
        $this->registerStock->reStocks($request->product_id, $request->Stocks);
        return response()->json(true, 200);
    }
}
