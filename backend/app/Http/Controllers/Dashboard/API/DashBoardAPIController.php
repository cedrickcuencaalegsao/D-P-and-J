<?php

namespace App\Http\Controllers\Dashboard\API;

use App\Application\Category\RegisterCategory;
use App\Application\Product\RegisterProduct;
use App\Application\Sales\RegisterSales;
use App\Application\Stock\RegisterStock;
use App\Application\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardAPIController extends Controller
{
    private RegisterUser $registerUser;
    private RegisterProduct $registerProduct;
    private RegisterSales $registerSales;
    private RegisterCategory $registerCategory;
    private RegisterStock $registerStock;

    /**
     * Constructor here.
     **/
    public function __construct(
        RegisterUser $registerUser,
        RegisterProduct $registerProduct,
        RegisterSales $registerSales,
        RegisterCategory $registerCategory,
        RegisterStock $registerStock,
    ) {
        $this->registerUser = $registerUser;
        $this->registerProduct = $registerProduct;
        $this->registerSales = $registerSales;
        $this->registerCategory = $registerCategory;
        $this->registerStock = $registerStock;
    }
    public function getUsers()
    {
        $userModel = $this->registerUser->findAll();

        if (!$userModel) {
            return null;
        }

        return array_map(
            fn($userModel) =>
            $userModel->toArray(),
            $userModel
        );
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
    public function getSales()
    {
        $salesModel = $this->registerSales->findAll();

        if (!$salesModel) {
            return null;
        }

        return array_map(
            fn($salesModel) =>
            $salesModel->toArray(),
            $salesModel
        );
    }
    public function getCategory()
    {
        $categoryModel = $this->registerCategory->findAll();

        if (!$categoryModel) {
            return null;
        }

        return array_map(
            fn($categoryModel) => $categoryModel->toArray(),
            $categoryModel
        );
    }
    public function getStocks()
    {
        $stockModel = $this->registerStock->findAll();

        if (!$stockModel) {
            return null;
        }

        return array_map(
            fn($stockModel) => $stockModel->toArray(),
            $stockModel
        );
    }

    public function getAllData()
    {
        return response()->json(
            [
                'countData' => [
                    'users' => count($this->getUsers() ?? []),
                    'products' => count($this->getProducts() ?? []),
                    'sales' => count($this->getSales() ?? []),
                    'categories' => count($this->getCategory() ?? []),
                    'stocks' => count($this->getStocks() ?? []),
                ],
                'data' => [
                    'users' => $this->getUsers(),
                    'products' => $this->getProducts(),
                    'sales' => $this->getSales(),
                    'categories' => $this->getCategory(),
                    'stocks' => $this->getStocks(),
                ],

            ]
        );
    }
    public function search(Request $searchTerm)
    {
        $searched = $searchTerm->input('searched');
        if (!$searched) {
            return response()->json(['message' => 'Invalid search. Please try again, after filling up the input search.'], 404);
        }
        $product = $this->registerProduct->search($searched);
        $category = $this->registerCategory->search($searched);
        $sales = $this->registerSales->search($searched);
        $stocks = $this->registerStock->search($searched);


        $result = [
            'Products' => $product,
            'Category' => $category,
            'Sales' => $sales,
            'Stocks' => $stocks,
        ];
        return response()->json(compact('result'), 200);
    }
}
