<?php

namespace App\Http\Controllers\Products\API;

use App\Application\Product\RegisterProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductAPIController extends Controller
{
    private RegisterProduct $registerProduct;
    public function __construct(RegisterProduct $registerProduct)
    {
        $this->registerProduct = $registerProduct;
    }
    public function getAll()
    {
        $productModel = $this->registerProduct->findAll();
        $products = array_map(fn($productModel) => $productModel->toArray(), $productModel);
        return response()->json(compact('products'), 200);
    }
}
