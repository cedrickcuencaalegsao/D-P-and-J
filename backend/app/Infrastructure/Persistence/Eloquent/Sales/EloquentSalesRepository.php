<?php

namespace App\Infrastructure\Persistence\Eloquent\Sales;

use App\Domain\Sale\SaleRepository;
use App\Domain\Sale\Sales;
use App\Infrastructure\Persistence\Eloquent\Product\ProductModel;

class EloquentSalesRepository implements SaleRepository
{
    public function findByID(int $id): ?Sales
    {
        $salesModel = SalesModel::find($id);
        return new Sales($salesModel->id, $salesModel->product_id, $salesModel->total_sales,);
    }
    public function findByProductID(string $product_id): ?Sales
    {
        $salesModel = SalesModel::find($product_id);
        if (!$salesModel) {
            return null;
        }
        return new Sales($salesModel->id, $salesModel->product_id, $salesModel->total_sales,);
    }
    public function findAll(): array
    {
        return SalesModel::all()->map(fn($salesModel) => new Sales(
            id: $salesModel->id,
            product_id: $salesModel->product_id,
            item_sold: $salesModel->item_sold,
            total_sales: $salesModel->total_sales,
            created_at: $salesModel->created_at,
            updated_at: $salesModel->updated_at
        ))->toArray();
    }
    public function create(Sales $sale): void
    {
        $salesModel = SalesModel::find($sale->getId()) ?? new ProductModel();
        $salesModel->id = $sale->getId();
        $salesModel->product_id = $sale->getProductID();
        $salesModel->total_sales = $sale->getTotalSales();
        $salesModel->save();
    }
    public function update(Sales $sale): void
    {
        $salesModel = SalesModel::find($sale->getId()) ?? new ProductModel();
        $salesModel->id = $sale->getId();
        $salesModel->product_id = $sale->getProductID();
        $salesModel->total_sales = $sale->getTotalSales();
        $salesModel->save();
    }
}
