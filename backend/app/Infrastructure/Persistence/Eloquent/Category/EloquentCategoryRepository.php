<?php

namespace App\Infrastructure\Persistence\Eloquent\Category;

use App\Domain\Category\CategoryRepository;
use App\Domain\Category\Category;

class EloquentCategoryRepository implements CategoryRepository
{
    public function findAll(): array
    {
        return CategoryModel::all()->map(fn($categoryModel) => new Category(
            id: $categoryModel->id,
            product_id: $categoryModel->product_id,
            category: $categoryModel->category,
            created_at: $categoryModel->created_at,
            updated_at: $categoryModel->updated_at,
        ))->toArray();
    }
    public function findByID(int $id): ?Category
    {
        $categoryModel = CategoryModel::find($id);
        if (!$categoryModel) {
            return null;
        }
        return new Category($categoryModel->id, $categoryModel->product_id, $categoryModel->category, $categoryModel->created_at, $categoryModel->updated_at);
    }
    public function findByProductID(string $product_id): ?Category
    {
        $categoryModel = CategoryModel::find($product_id);
        if (!$categoryModel) {
            return null;
        }
        return new Category($categoryModel->id, $categoryModel->product_id, $categoryModel->category, $categoryModel->created_at, $categoryModel->updated_at);
    }
    public function create(Category $category): void
    {
        $categoryModel = CategoryModel::find($category->getId()) ?? new CategoryModel();
        $categoryModel->id = $category->getId();
        $categoryModel->product_id = $category->getPoductId();
        $categoryModel->category = $category->getCategory();
        $categoryModel->created_at = $category->Created();
        $categoryModel->updated_at = $category->Update();
        $categoryModel->save();
    }
    public function update(Category $category): void
    {
        $categoryModel = CategoryModel::find($category->getId()) ?? new CategoryModel();
        $categoryModel->id = $category->getId();
        $categoryModel->product_id = $category->getPoductId();
        $categoryModel->category = $category->getCategory();
        $categoryModel->updated_at = $category->Update();
        $categoryModel->updated_at = $category->Update();
        $categoryModel->save();
    }
}
