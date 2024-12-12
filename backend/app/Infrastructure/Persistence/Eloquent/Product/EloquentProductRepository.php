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
            $productModel->retrieve_price,
            $productModel->retailed_price,
            $productModel->image,
            $productModel->category?->category,
        );
    }
    public function findByProductID(string $product_id): ?Product
    {
        $productModel = ProductModel::with(['category'])->where('product_id', $product_id)->first();
        if (!$productModel) {
            return null;
        }
        return new Product(
            $productModel->id,
            $productModel->product_id,
            $productModel->name,
            $productModel->retrieve_price,
            $productModel->retailed_price,
            $productModel->image,
            $productModel->category?->category,
        );
    }
    public function create(Product $product): void
    {
        $productModel = ProductModel::find($product->getId()) ?? new ProductModel();
        $productModel->id = $product->getId();
        $productModel->product_id = $product->getProductID();
        $productModel->name = $product->getName();
        $productModel->retrieve_price = $product->getPrice();
        $productModel->retailed_price = $product->getRetailedPrice();
        $productModel->image = $product->getImage();
        $productModel->save();
    }
    public function update(Product $product): void
    {
        $existingProduct = ProductModel::where('product_id', $product->getProductID())->first();
        if ($existingProduct) {
            $existingProduct->name = $product->getName();
            $existingProduct->retrieve_price = $product->getPrice();
            $existingProduct->retailed_price = $product->getRetailedPrice();
            $existingProduct->image = $product->getImage();
            $existingProduct->save();
        } else {
            $productModel = new ProductModel();
            $productModel->id = $product->getId();
            $productModel->product_id = $product->getProductID();
            $productModel->name = $product->getName();
            $productModel->retrieve_price = $product->getPrice();
            $productModel->retailed_price = $product->getRetailedPrice();
            $productModel->image = $product->getImage();
            $productModel->save();
        }
    }
    public function findAll(): array
    {
        return ProductModel::with('category')->get()->map(fn($productModel) => new Product(
            $productModel->id,
            $productModel->product_id,
            $productModel->name,
            $productModel->retrieve_price,
            $productModel->retailed_price,
            $productModel->image,
            $productModel->category?->category,
        ))->toArray();
    }
    public function searchProduct(string $search): array
    {
        $match = ProductModel::where('product_id', $search)->orWhere('name', $search)->orWhere('retrieve_price', $search)->orWhere('retailed_price', $search)->get();

        $related = ProductModel::where('id', '!=', $match->pluck('id'))
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('product_id', 'LIKE', "%{$search}%")
            ->orWhere('retrieve_price', 'LIKE', "%{$search}%")
            ->orWhere('retailed_price', 'LIKE', "%{$search}%")->get();

        return [
            'match' => $match->map(function ($product) {
                return new Product(
                    $product->id,
                    $product->product_id,
                    $product->name,
                    $product->retrieve_price,
                    $product->retailed_price,
                    $product->image,
                    $product->category->category,
                );
            })->toArray(),
            'related' => $related->map(
                function ($product) {
                    return new Product(
                        $product->id,
                        $product->product_id,
                        $product->name,
                        $product->retrieve_price,
                        $product->retailed_price,
                        $product->image,
                        $product->category->category,
                    );
                }
            )->toArray()
        ];
    }
}
