<?php

namespace App\Http\Controllers\Sales\WEB;

use App\Application\Sales\RegisterSales;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesWEBController extends Controller
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
