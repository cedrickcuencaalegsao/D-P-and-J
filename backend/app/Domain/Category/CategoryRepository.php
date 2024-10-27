<?php

namespace App\Domain\Category;

interface CategoryRepository
{
    public function create(Category $category): void;
    public function update(Category $category): void;
    public function findByID(int $id): ?Category;
    public function findByProductID(string $product_id): ?Category;
    public function findAll(): array;
    public function searchCategory(string $search): array;
}
