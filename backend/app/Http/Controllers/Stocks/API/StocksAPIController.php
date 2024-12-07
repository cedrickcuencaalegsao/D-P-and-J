<?php

namespace App\Http\Controllers\Stocks\API;

use App\Application\Sales\RegisterSales;
use App\Application\Stock\RegisterStock;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StocksAPIController extends Controller
{
    private RegisterStock $registerStock;
    private RegisterSales $registerSales;

    public function __construct(RegisterStock $registerStock, RegisterSales $registerSales)
    {
        $this->registerStock = $registerStock;
        $this->registerSales = $registerSales;
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
        $validate = Validator::make($request->all(), [
            'product_id' => 'required',
            'retailed_price' => 'required',
            'retrieve_price' => 'required',
            'quantity' => 'required'
        ]);
        if ($validate->fails()) {
            return response()->json($validate->errors(), 422);
        }

        if ($request->quantity === "0") {
            return response()->json(['message' => "Invalid Action: Quantity must not be equal to zero."]);
        }

        $stockModel = $this->registerStock->findByProductID(
            $request->product_id
        );
        if (!$stockModel || $stockModel->getStocks() <= 0) {
            return response()->json(["message" => "Invalid product ID. Please Restock the product first."], 404);
        }
        $this->registerStock->buyProduct($request->product_id, $request->quantity);
        $total_sales = floatval($request->retailed_price) *  floatval($request->quantity);
        // return response()->json($total_sales);
        $this->productSales(
            $request->quantity,
            $request->product_id,
            $request->retailed_price,
            $request->retrieve_price,
            $total_sales,
            Carbon::now()->toDateTimeString(),
            Carbon::now()->toDateTimeString()
        );
        return response()->json(["message" => "Product bought successfully"], 200);
    }
    /**
     * Update Product sale at sales table.
     * **/
    public function productSales(
        int $item_sold,
        string $product_id,
        float $retailed_price,
        float $retrieve_price,
        float $total_sales,
        string $created_at,
        string $updated_at
    ) {
        $this->registerSales->create(
            $item_sold,
            $product_id,
            $retailed_price,
            $retrieve_price,
            $total_sales,
            $created_at,
            $updated_at
        );
    }
    /**
     * Restock a product.
     * **/
    public function reStocks(Request $request)
    {
        $stockModel = $this->registerStock->findByProductID(
            $request->product_id
        );
        if (!$stockModel) {
            return response()->json(["message" => "Invalid product ID. Please Restock the product first."], 404);
        }
        $this->registerStock->reStocks($request->product_id, $request->stocks);
        return response()->json(true, 200);
    }
}
