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
            name: $categoryModel->product?->name,
            stock: $categoryModel->stock?->stocks,
        ))->toArray();
    }
    public function findByID(int $id): ?Category
    {
        $categoryModel = CategoryModel::find($id);
        if (!$categoryModel) {
            return null;
        }
        return new Category(null, $categoryModel->product_id, $categoryModel->category, $categoryModel->created_at, $categoryModel->updated_at);
    }
    public function findByProductID(string $product_id): ?Category
    {
        $categoryModel = CategoryModel::where('product_id', $product_id)->first();
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
        $existingCategory = CategoryModel::where('product_id', $category->getPoductId())->first();
        if ($existingCategory) {
            $existingCategory->category = $category->getCategory();
            $existingCategory->updated_at = $category->Update();
            $existingCategory->save();
        } else {
            $categoryModel = new CategoryModel();
            $categoryModel->id = $category->getId();
            $categoryModel->product_id = $category->getPoductId();
            $categoryModel->category = $category->getCategory();
            $categoryModel->updated_at = $category->Update();
            $categoryModel->save();
        }
    }
    public function searchCategory(string $search): array
    {
        $match = CategoryModel::where('product_id', $search)
            ->orWhere('category', $search)->first();

        $related = CategoryModel::where('product_id', 'LIKE', "%{$search}%")
            ->orWhere('category', 'LIKE', "%{$search}%")->get();

        return [
            'match' => $match ? new Category(
                $match->id,
                $match->product_id,
                $match->category,
                $match->created_at,
                $match->updated_at,
                $match->product?->name,
                $match->stock?->stocks,
            ) : null,
            'related' => $related->map(function ($category) {
                return new Category(
                    $category->id,
                    $category->product_id,
                    $category->category,
                    $category->created_at,
                    $category->updated_at,
                    $category->product?->name,
                    $category->stock?->stocks,
                );
            })->toArray()
        ];
    }
}
