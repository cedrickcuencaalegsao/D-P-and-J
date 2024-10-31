<?php

namespace App\Http\Controllers\Dashboard\API;

use App\Application\Category\RegisterCategory;
use App\Application\Product\RegisterProduct;
use App\Application\Report\RegisterReport;
use App\Application\Sales\RegisterSales;
use App\Application\Stock\RegisterStock;
use App\Application\User\RegisterUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashBoardAPIController extends Controller
{
    private RegisterUser $registerUser;
    private RegisterProduct $registerProduct;
    private RegisterSales $registerSales;
    private RegisterCategory $registerCategory;
    private RegisterStock $registerStock;
    private RegisterReport $registerReport;

    /**
     * Constructor here.
     **/
    public function __construct(
        RegisterUser $registerUser,
        RegisterProduct $registerProduct,
        RegisterSales $registerSales,
        RegisterCategory $registerCategory,
        RegisterStock $registerStock,
        RegisterReport $registerReport,
    ) {
        $this->registerUser = $registerUser;
        $this->registerProduct = $registerProduct;
        $this->registerSales = $registerSales;
        $this->registerCategory = $registerCategory;
        $this->registerStock = $registerStock;
        $this->registerReport = $registerReport;
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
    public function getReports()
    {
        $reportsModel = $this->registerReport->findAll();

        if (!$reportsModel) {
            return null;
        }

        return array_map(
            fn($reportsModel) => $reportsModel->toArray(),
            $reportsModel
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
                    'reports' => count($this->getReports() ?? []),
                ],
                'data' => [
                    'users' => $this->getUsers(),
                    'products' => $this->getProducts(),
                    'sales' => $this->getSales(),
                    'categories' => $this->getCategory(),
                    'stocks' => $this->getStocks(),
                    'reports' => $this->getReports(),
                ],

            ]
        );
    }
}
