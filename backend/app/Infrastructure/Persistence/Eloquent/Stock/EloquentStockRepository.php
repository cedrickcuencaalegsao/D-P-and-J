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
            $stockModel->updated_at,
            $stockModel->product->name,
            $stockModel->category->category,
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
    public function searchStock(string $search): array
    {
        $match = StockModel::where('product_id', $search)->orWhere('stocks', $search)->first();
        $related = StockModel::where('id', '!=', $match?->id)->orWhere('product_id', 'LIKE', '%{$search}%')->orWhere('stocks', 'LIKE', '%{$search}%')->get();
        return [
            'match' => $match ? new Stock(
                $match->id,
                $match->product_id,
                $match->stocks,
                $match->created_at,
                $match->updated_at,
                $match->product->name,
                $match->category->category,
            ) : null,
            'related' => $related->map(function ($stocks) {
                return new Stock(
                    $stocks->id,
                    $stocks->product_id,
                    $stocks->stocks,
                    $stocks->created_at,
                    $stocks->updated_at,
                    $stocks->product->name,
                    $stocks->category->category,
                );
            })->toArray(),
        ];
    }
}
