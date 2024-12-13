<?php

namespace App\Http\Controllers\Stocks\WEB;

use App\Application\Stock\RegisterStock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StockWEBController extends Controller
{
    private RegisterStock $registerStock;
    public function __construct(RegisterStock $registerStock)
    {
        $this->registerStock = $registerStock;
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
}
