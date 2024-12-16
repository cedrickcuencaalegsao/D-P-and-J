<?php

namespace App\Http\Controllers\Stocks\WEB;

use App\Application\Sales\RegisterSales;
use App\Application\Stock\RegisterStock;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockWEBController extends Controller
{
    private RegisterStock $registerStock;
    private RegisterSales $registerSales;
    public function __construct(RegisterStock $registerStock, RegisterSales $registerSales)
    {
        $this->registerStock = $registerStock;
        $this->registerSales = $registerSales;
    }
    /**
     * View Stocks.
     * **/
    public function index()
    {
        $data = $this->registerStock->findAll();
        return view('Pages.Stock.index', compact('data'));
    }
    public function updateStock(Request $request)
    {
        $data = $request->all();
        // dd($data);
        if (intval($data['stocks']) === 0) {
            return redirect()->back()->with('error', 'New stock cannot be 0.');
        }

        $stockModel = $this->registerStock->findByProductID(
            $request->product_id
        );
        if (!$stockModel) {
            return redirect()->back()->with('error', 'Invalid product ID. Please Restock the product first.');
        }
        $this->registerStock->reStocks($request->product_id, $request->stocks);
        return redirect()->back()->with('success', 'Stock updated successfully');
    }
    /**
     * Buy a product.
     * **/
    public function buyProduct(Request $request)
    {
        // dd($request->all());
        $validate = Validator::make($request->all(), [
            'product_id' => 'required',
            'retailed_price' => 'required',
            'retrieve_price' => 'required',
            'quantity' => 'required'
        ]);
        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Invalid request.Please try again.');
        }

        if ($request->quantity === "0") {
            return redirect()->back()->with('error', 'Quantity cannot be 0.');
        }

        $stockModel = $this->registerStock->findByProductID(
            $request->product_id
        );
        if (!$stockModel || $stockModel->getStocks() <= 0) {
            return redirect()->back()->with('error', 'Product is currently out of stock.');
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
        return redirect()->back()->with('success', "Product bought successfully");
    }
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
}
