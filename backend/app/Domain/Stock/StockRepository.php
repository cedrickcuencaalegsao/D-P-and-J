<?php

namespace App\Domain\Stock;

interface StockRepository
{
    public function create(Stock $stock): void;
    public function update(Stock $stock): void;
    public function findByID(int $id): ?Stock;
    public function findByProductID(string $product_id): ?Stock;
    public function findAll(): array;
    public function buyProduct(string $product_id, int $quantity): void;
    public function reStocks(string $product_id, int $quantity): void;
    public function searchStock(string $searchTerm): array;
}
