<?php

namespace App\Infrastructure\Persistence\Eloquent\Stock;

use App\Domain\Stock\StockRepository;
use App\Domain\Stock\Stock;

class EloquentStockRepository implements StockRepository
{
    public function findByID(int $id): ?Stock
    {
        $stockModel = StockModel::find($id);
        if (!$stockModel) {
            return null;
        }
        return new Stock(
            $stockModel->id,
            $stockModel->product_id,
            $stockModel->stock,
            $stockModel->created_at,
            $stockModel->updated_at
        );
    }
    public function findByProductID(string $product_id): ?Stock
    {
        $stockModel = StockModel::where('product_id', $product_id)->first();
        if (!$stockModel) {
            return null;
        }
        return new Stock(
            $stockModel->id,
            $stockModel->product_id,
            $stockModel->stocks,
            $stockModel->created_at,
            $stockModel->updated_at
        );
    }
    public function findAll(): array
    {
        return StockModel::orderBy('stocks', 'asc') // Order by 'stocks' in ascending order
            ->get()
            ->map(fn($stockModel) => new Stock(
                id: $stockModel->id,
                product_id: $stockModel->product_id,
                stocks: $stockModel->stocks,
                name: $stockModel->product->name,
                category: $stockModel->category->category,
                created_at: $stockModel->created_at,
                updated_at: $stockModel->updated_at,
            ))
            ->toArray();
    }
    public function create(Stock $stock): void
    {
        $stockModel = StockModel::find($stock->getId()) ?? new StockModel();
        $stockModel->id = $stock->getId();
        $stockModel->product_id = $stock->getByProductID();
        $stockModel->stocks = $stock->getStocks();
        $stockModel->created_at = $stock->created();
        $stockModel->updated_at = $stock->updated();
        $stockModel->save();
    }
    public function update(Stock $stock): void
    {
        $stockModel = StockModel::find($stock->getId()) ?? new StockModel();
        $stockModel->id = $stock->getId();
        $stockModel->product_id = $stock->getByProductID();
        $stockModel->stock = $stock->getStocks();
        $stockModel->updated_at = $stock->updated();
        $stockModel->save();
    }
    public function buyProduct(string $product_id, int $quantity): void
    {
        $stockModel = StockModel::where('product_id', $product_id)->first();
        if (!$stockModel) {
            return;
        }
        $stockModel->stocks = $stockModel->stocks - $quantity;
        $stockModel->updated_at = now();
        $stockModel->save();
    }
    public function reStocks(string $product_id, int $quantity): void
    {
        $stockModel = StockModel::where('product_id', $product_id)->first();
        if (!$stockModel) {
            return;
        }
        $stockModel->stocks = $quantity;
        $stockModel->updated_at = now();
        $stockModel->save();
    }
}
