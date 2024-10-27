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
        return new Product($productModel->id, $productModel->product_id, $productModel->name, $productModel->price, $productModel->created_at, $productModel->updated_at);
    }
    public function findByProductID(string $product_id): ?Product
    {
        $productModel = ProductModel::where('product_id', $product_id)->first();
        if (!$productModel) {
            return null;
        }
        return new Product($productModel->id, $productModel->product_id, $productModel->name, $productModel->price, $productModel->created_at, $productModel->updated_at);
    }
    public function create(Product $product): void
    {
        $productModel = ProductModel::find($product->getId()) ?? new ProductModel();
        $productModel->id = $product->getId();
        $productModel->product_id = $product->getProductID();
        $productModel->name = $product->getName();
        $productModel->price = $product->getPrice();
        $productModel->created_at = $product->Created();
        $productModel->updated_at = $product->Updated();
        $productModel->save();
    }
    public function update(Product $product): void
    {
        $productModel = ProductModel::find($product->getId()) ?? new ProductModel();
        $productModel->id = $product->getId();
        $productModel->product_id = $product->getProductID();
        $productModel->name = $product->getName();
        $productModel->price = $product->getPrice();
        $productModel->created_at = $product->Created();
        $productModel->updated_at = $product->Updated();
        $productModel->save();
    }
    public function findAll(): array
    {
        return ProductModel::all()->map(fn($productModel) => new Product(
            $productModel->id,
            $productModel->product_id,
            $productModel->name,
            $productModel->price,
            $productModel->created_at,
            $productModel->updated_at,
        ))->toArray();
    }
    public function searchProduct(string $search): array
    {
        $match = ProductModel::where('product_id', $search)->orWhere('name', $search)->orWhere('price')->first();

        $related = ProductModel::where('id', '!=', $match?->id)
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('product_id', 'LIKE', "%{$search}%")
            ->orWhere('price', 'LIKE', "%{$search}%")->get();

        return [
            'match' => $match ? new Product(
                $match->id,
                $match->product_id,
                $match->name,
                $match->price,
                $match->created_at,
                $match->updated_at,
            ) : null,
            'related' => $related->map(
                function ($product) {
                    return new Product(
                        $product->id,
                        $product->product_id,
                        $product->name,
                        $product->price,
                        $product->created_at,
                        $product->updated_at,
                    );
                }
            )->toArray()
        ];
    }
}
