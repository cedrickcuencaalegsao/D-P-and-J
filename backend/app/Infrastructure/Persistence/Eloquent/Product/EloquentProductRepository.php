<?php

namespace App\Infrastructure\Persistence\Eloquent\Product;

use App\Domain\Product\ProductRepository;
use App\Domain\Product\Product;

class EloquentProductRepository implements ProductRepository
{
    public function findById(int $id): ?Product
    {
        $productModel = ProductModel::find($id);
        if (!$productModel) {
            return null;
        }
        return new Product($productModel->id, $productModel->product_id, $productModel->name, $productModel->price);
    }
    public function findByProductID(string $product_id): ?Product
    {
        $productModel = ProductModel::find($product_id);
        if (!$productModel) {
            return null;
        }
        return new Product($productModel->id, $productModel->product_id, $productModel->name, $productModel->price,);
    }
    public function create(Product $product): void
    {
        $productModel = ProductModel::find($product->getId()) ?? new ProductModel();
        $productModel->id = $product->getId();
        $productModel->name = $product->getName();
        $productModel->price = $product->getPrice();
        $productModel->save();
    }
    public function update(Product $product): void
    {
        $productModel = ProductModel::find($product->getId()) ?? new ProductModel();
        $productModel->id = $product->getId();
        $productModel->name = $product->getName();
        $productModel->price = $product->getPrice();
        $productModel->save();
    }
    public function findAll(): array
    {
        return ProductModel::all()->map(fn($productModel) => new Product(
            id: $productModel->id,
            product_id: $productModel->product_id,
            name: $productModel->name,
            price: $productModel->price,
        ))->toArray();
    }
}
