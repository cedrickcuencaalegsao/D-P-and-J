<?php

namespace App\Http\Controllers\Sales\Web;

use App\Application\Sales\RegisterSales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesWebController extends Controller
{
    private RegisterSales $registerSales;
    public function __construct(RegisterSales $registerSales)
    {
        $this->registerSales = $registerSales;
    }
    /**
     * View Sales.
     * **/
    public function index()
    {
        $data = $this->registerSales->findAll();
        return view('Pages.Report.index', compact('data'));
    }
}
