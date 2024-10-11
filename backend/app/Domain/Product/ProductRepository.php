<?php

namespace App\Domain\Product;

interface ProductRepository
{
    public function create(Product $product): void;
    public function update(Product $product): void;
    public function findByID(int $id): ?Product;
    public function findAll(): array;
}
