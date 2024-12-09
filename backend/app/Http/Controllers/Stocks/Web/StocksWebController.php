<?php

namespace App\Http\Controllers\Stocks\Web;

use App\Application\Stock\RegisterStock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StocksWebController extends Controller
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
}
