<?php

namespace App\Http\Controllers\Products\Web;

use App\Application\Product\RegisterProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductWebController extends Controller
{
    private RegisterProduct $registerProduct;
    public function __construct(RegisterProduct $registerProduct)
    {
        $this->registerProduct = $registerProduct;
    }
    /**
     * View Products.
     * **/
    public function index()
    {
        $data = $this->registerProduct->findAll();
        return view('Pages.Product.index', compact('data'));
    }
}
