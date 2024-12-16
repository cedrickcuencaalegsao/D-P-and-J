<?php

namespace App\Http\Controllers\Reports\WEB;

use App\Application\Sales\RegisterSales;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportsWEBController extends Controller
{
    private RegisterSales $registerSales;
    public function __construct(RegisterSales $registerSales)
    {
        $this->registerSales = $registerSales;
    }
    public function getSalesData(): array
    {
        $saleModel = $this->registerSales->findAll();
        return array_map(fn($saleModel) => $saleModel->toArray(), $saleModel);
    }
    public function index(): View
    {
        $data = $this->getSalesData();
        return view('Pages.Report.index', compact('data'));
    }
}
