<?php

namespace App\Application\Category;

use App\Domain\Category\Category;
use App\Domain\Category\CategoryRepository;

class RegisterCategory
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function create(string $product_id, string $category, string $created_at, string $updated_at)
    {

        $data = new Category(null, $product_id, $category, $created_at, $updated_at);
        $this->categoryRepository->create($data);
    }
    public function update(string $product_id, string $category,string $updated_at)
    {
        $validate = $this->categoryRepository->findByProductID($product_id);

        if (!$validate) {
            throw new \Exception('Category Not Found!');
        }
        $data = new Category(
            id: null,
            product_id: $product_id,
            category: $category,
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
    public function search(string $search): array
    {
        $category = $this->categoryRepository->searchCategory($search);

        return [
            'martch' => $category['match'] ? $category['match']->toArray() : null,
            'related' => array_map(function ($category) {
                return $category->toArray();
            }, $category['related'])
        ];
    }
}
