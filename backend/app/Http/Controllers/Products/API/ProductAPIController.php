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
        $data = $this->registerProduct->findAll();
        return response()->json(compact('data'));
    }
}
