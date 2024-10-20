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
        $stockModel = StockModel::find($product_id);
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
    public function findAll(): array
    {
        return StockModel::all()->map(fn($stockModel) => new Stock(
            id: $stockModel->id,
            product_id: $stockModel->product_id,
            stocks: $stockModel->stocks,
            created_at: $stockModel->created_at,
            updated_at: $stockModel->updated_at,
        ))->toArray();
    }
    public function create(Stock $stock): void
    {
        $stockModel = StockModel::find($stock->getId()) ?? new StockModel();
        $stockModel->id = $stock->getId();
        $stockModel->product_id = $stock->getByProductID();
        $stockModel->stock = $stock->getStock();
        $stockModel->created_at = $stock->created();
        $stockModel->save();
    }
    public function update(Stock $stock): void
    {
        $stockModel = StockModel::find($stock->getId()) ?? new StockModel();
        $stockModel->id = $stock->getId();
        $stockModel->product_id = $stock->getByProductID();
        $stockModel->stock = $stock->getStock();
        $stockModel->updated_at = $stock->updated();
        $stockModel->save();
    }
}
