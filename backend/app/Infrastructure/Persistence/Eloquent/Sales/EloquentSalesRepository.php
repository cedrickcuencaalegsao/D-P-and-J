<?php

namespace App\Infrastructure\Persistence\Eloquent\Sales;

use App\Domain\Sale\SaleRepository;
use App\Domain\Sale\Sales;

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
        $salesModel = SalesModel::find($sale->getId()) ?? new SalesModel();
        $salesModel->id = $sale->getId();
        $salesModel->product_id = $sale->getProductID();
        $salesModel->item_sold = $sale->getByItemSold();
        $salesModel->retailed_price = $sale->getRetailedPrice();
        $salesModel->retrieve_price = $sale->getRetrievePrice();
        $salesModel->total_sales = $sale->getTotalSales();
        $salesModel->created_at = $sale->Created();
        $salesModel->updated_at = $sale->Updated();
        $salesModel->save();
    }
    public function update(Sales $sale): void
    {
        $salesModel = SalesModel::find($sale->getId()) ?? new SalesModel();
        $salesModel->id = $sale->getId();
        $salesModel->product_id = $sale->getProductID();
        $salesModel->total_sales = $sale->getTotalSales();
        $salesModel->save();
    }
}
