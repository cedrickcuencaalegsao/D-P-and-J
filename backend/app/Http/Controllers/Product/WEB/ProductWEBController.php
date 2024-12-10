<?php

namespace App\Http\Controllers\Product\WEB;

use App\Application\Product\RegisterProduct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductWEBController extends Controller
{
    private RegisterProduct $registerProduct;
    public function __construct(RegisterProduct $registerProduct)
    {
        $this->registerProduct = $registerProduct;
    }
    public function getProducts()
    {
        $productModel = $this->registerProduct->findAll();

        if (!$productModel) {
            return null;
        }

        return array_map(
            fn($productModel) =>
            $productModel->toArray(),
            $productModel
        );
    }
    /**
     * View Products.
     * **/
    public function index()
    {
        $data = $this->getProducts();
        // dd($data);
        return view('Pages.Product.index', compact('data'));
    }
}
