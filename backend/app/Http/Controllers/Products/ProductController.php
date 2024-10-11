<?php

namespace App\Http\Controllers\Products;

use App\Application\Product\RegisterProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private RegisterProduct $registerProduct;
    public function __construct(RegisterProduct $registerProduct)
    {
        $this->registerProduct = $registerProduct;
    }

    public function getAllProdutcs()
    {
        $data = $this->registerProduct->findAll();
        return response()->json(compact('data'));
    }
    public function index()
    {
        $data = $this->registerProduct->findAll();
        return view('Product.index', compact('data'));
    }
}
