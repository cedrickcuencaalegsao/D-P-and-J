<?php

namespace App\Infrastructure\Persistence\Eloquent\Sales;

use App\Domain\Sale\SaleRepository;
use App\Domain\Sale\Sales;
use Carbon\Carbon;

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
        return  SalesModel::orderBy('total_sales', 'desc')->get()
            ->map(fn($salesModel) => new Sales(
                id: $salesModel->id,
                product_id: $salesModel->product_id,
                item_sold: $salesModel->item_sold,
                total_sales: $salesModel->total_sales,
                retailed_price: $salesModel->retailed_price,
                retrieve_price: $salesModel->retrieve_price,
                name: $salesModel->product?->name,
                category: $salesModel->category?->category,
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
    public function productSales(string $product_id, int $quantity): void
    {
        $salesModel = SalesModel::where("product_id", $product_id)->first();
        $sales = $salesModel->retailed_price * $quantity;
        if ($salesModel) {
            $salesModel->item_sold = $salesModel->item_sold + $quantity;
            $salesModel->total_sales = $salesModel->total_sales + $sales;
            $salesModel->updated_at = Carbon::now()->toDateTimeString();
            $salesModel->save();
        }
    }
    public function searchSales(string $search): array
    {
        $match = SalesModel::where("product_id", $search)->orWhere('item_sold')->orWhere('retailed_price')->orWhere('retrieve_price')->orWhere('total_sales')->first();

        $related = SalesModel::where('id', '!=', $match?->id)->orWhere('product_id', 'LIKE', '%{$search}%')
            ->where('item_sold', 'LIKE', '%{$search}%')->where('retailed_price', 'LIKE', '%{$search}%')->where('retrieve_price', 'LIKE', '%{$search}%')->where('item_sold', 'LIKE', '%{$search}%')->get();
        return [
            'match' => $match ? new Sales(
                $match->id,
                $match->product_id,
                $match->item_sold,
                $match->retailed_price,
                $match->retrieve_price,
                $match->total_sales,
                $match->created_at,
                $match->updated_at,
                $match->category->category,
                $match->product->name,
            ) : null,
            'related' => $related->map(function ($sales) {
                return new Sales(
                    $sales->id,
                    $sales->product_id,
                    $sales->item_sold,
                    $sales->retailed_price,
                    $sales->retrieve_price,
                    $sales->total_sales,
                    $sales->created_at,
                    $sales->updated_at,
                    $sales->category->category,
                    $sales->product->name,
                );
            })->toArray(),
        ];
    }
}
