<?php

namespace App\Application\Category;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;
use App\Domain\Product\Product;

class RegisterCategory
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function create(int $id, string $product_id, string $category, string $created_at, string $updated_at)
    {

        $data = new Category($id, $product_id, $category, $created_at, $updated_at);
        $this->categoryRepository->create($data);
    }
    public function update(int $id, string $product_id, string $category, string $created_at, string $updated_at)
    {
        $validate = $this->categoryRepository->findByID($id);

        if (!$validate) {
            throw new \Exception('Category Not Found!');
        }
        $data = new Category(
            id: $id,
            product_id: $product_id,
            category: $category,
            created_at: $created_at,
            updated_at: $updated_at,
        );
        $this->categoryRepository->update($data);
    }
    public function findByID(int $id)
    {
        return $this->categoryRepository->findByID($id);
    }
    public function findByProductID(string $product_id)
    {
        return $this->categoryRepository->findByProductID($product_id);
    }
    public function findAll(): array
    {
        return $this->categoryRepository->findAll();
    }
}
