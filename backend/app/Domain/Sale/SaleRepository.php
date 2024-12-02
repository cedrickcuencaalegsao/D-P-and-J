<?php

namespace App\Domain\Sale;

interface SaleRepository
{
    public function create(Sales $sale): void;
    public function update(Sales $sale): void;
    public function findByID(int $id): ?Sales;
    public function findByProductID(string $product_id): ?Sales;
    public function findAll(): array;
    public function searchSales(string $seach): array;
}
