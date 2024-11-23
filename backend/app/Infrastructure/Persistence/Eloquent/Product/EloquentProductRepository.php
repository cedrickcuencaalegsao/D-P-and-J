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
        return new Product(
            $productModel->id,
            $productModel->product_id,
            $productModel->name,
            $productModel->price,
            $productModel->image,
            $productModel->created_at,
            $productModel->updated_at,
            $productModel->category,
        );
    }
    public function findByProductID(string $product_id): ?Product
    {
        $productModel = ProductModel::with(['category', 'sales'])->where('product_id', $product_id)->first();
        if (!$productModel) {
            return null;
        }
        return new Product(
            $productModel->id,
            $productModel->product_id,
            $productModel->name,
            $productModel->price,
            $productModel->image,
            $productModel->created_at,
            $productModel->updated_at,
            $productModel->category?->category,
        );
    }
    public function create(Product $product): void
    {
        $productModel = ProductModel::find($product->getId()) ?? new ProductModel();
        $productModel->id = $product->getId();
        $productModel->product_id = $product->getProductID();
        $productModel->name = $product->getName();
        $productModel->price = $product->getPrice();
        $productModel->image = $product->getImage();
        $productModel->created_at = $product->Created();
        $productModel->updated_at = $product->Updated();
        $productModel->save();
    }
    public function update(Product $product): void
    {
        $existingProduct = ProductModel::where('product_id', $product->getProductID())->first();
        if ($existingProduct) {
            $existingProduct->name = $product->getName();
            $existingProduct->price = $product->getPrice();
            $existingProduct->image = $product->getImage();
            $existingProduct->updated_at = $product->Updated();
            $existingProduct->save();
        } else {
            $productModel = new ProductModel();
            $productModel->id = $product->getId();
            $productModel->product_id = $product->getProductID();
            $productModel->name = $product->getName();
            $productModel->price = $product->getPrice();
            $productModel->image = $product->getImage();
            $productModel->updated_at = $product->Updated();
            $productModel->save();
        }
    }
    public function findAll(): array
    {
        return ProductModel::with('category')->get()->map(fn($productModel) => new Product(
            $productModel->id,
            $productModel->product_id,
            $productModel->name,
            $productModel->price,
            $productModel->image,
            $productModel->updated_at,
            $productModel->created_at,
            $productModel->category?->category,
            $productModel->sales?->retailed_price,
        ))->toArray();
    }
    public function searchProduct(string $search): array
    {
        $match = ProductModel::where('product_id', $search)->orWhere('name', $search)->orWhere('price', $search)->get();

        $related = ProductModel::where('id', '!=', $match->pluck('id'))
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('product_id', 'LIKE', "%{$search}%")
            ->orWhere('price', 'LIKE', "%{$search}%")->get();

        return [
            'match' => $match->map(function ($product) {
                return new Product(
                    $product->id,
                    $product->product_id,
                    $product->name,
                    $product->price,
                    $product->image,
                    $product->created_at,
                    $product->updated_at,
                    $product->category->category,
                    $product->sales->retailed_price,
                );
            })->toArray(),
            'related' => $related->map(
                function ($product) {
                    return new Product(
                        $product->id,
                        $product->product_id,
                        $product->name,
                        $product->price,
                        $product->image,
                        $product->created_at,
                        $product->updated_at,
                        $product->category->category,
                        $product->sales->retailed_price,
                    );
                }
            )->toArray()
        ];
    }
}
