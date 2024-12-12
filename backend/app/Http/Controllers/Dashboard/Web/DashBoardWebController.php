<?php

namespace App\Http\Controllers\Dashboard\WEB;

use App\Application\Category\RegisterCategory;
use App\Application\Product\RegisterProduct;
use App\Application\Sales\RegisterSales;
use App\Application\Stock\RegisterStock;
use App\Application\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardWEBController extends Controller
{
    private RegisterUser $registerUser;
    private RegisterProduct $registerProduct;
    private RegisterSales $registerSales;
    private RegisterStock $registerStock;
    private RegisterCategory $registerCategory;

    public function __construct(RegisterUser $registerUser, RegisterProduct $registerProduct, RegisterSales $registerSales, RegisterStock $registerStock, RegisterCategory $registerCategory,)
    {
        $this->registerUser = $registerUser;
        $this->registerProduct = $registerProduct;
        $this->registerSales = $registerSales;
        $this->registerStock = $registerStock;
        $this->registerCategory = $registerCategory;
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

    /**
     * View Dashboard.
     * **/
    public function viewDashBoard()
    {
        $data = [
            'usersCount' => count($this->getUsers() ?? []),
            'productsCount' => count($this->getProducts() ?? []),
            'salesCount' => count($this->getSales() ?? []),
            'categoriesCount' => count($this->getCategory() ?? []),
            'stocksCount' => count($this->getStocks() ?? []),
            'users' => $this->getUsers(),
            'products' => $this->getProducts(),
            'sales' => $this->getSales(),
            'categories' => $this->getCategory(),
            'stocks' => $this->getStocks(),
        ];

        return view('Pages.Dashboard.index', compact('data'));
    }
}
