<?php

namespace App\Application\Product;

use App\Domain\Product\ProductRepository;
use App\Domain\Product\Product;

class RegisterProduct
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    public function create(
        string $product_id,
        string $name,
        float $price,
        string $image,
        string $created_at,
        string $updated_at
    ) {
        $data = new Product(
            null,
            $product_id,
            $name,
            $price,
            $image,
            $created_at,
            $updated_at,
        );
        $this->productRepository->create($data);
    }
    public function update(int $id, string $product_id, string $name, float $price, string $updated_at)
    {
        $validate = $this->productRepository->findByID($id);

        if (!$validate) {
            throw new \Exception('Product Not found!');
        }
        $updateProduct = new Product(
            id: $id,
            product_id: $product_id,
            name: $name,
            price: $price,
            updated_at: $updated_at,
        );
        $this->productRepository->update($updateProduct);
    }

    public function findByID(int $id)
    {
        return $this->productRepository->findByID($id);
    }
    public function findByProductID(string $product_id)
    {
        return $this->productRepository->findByProductID($product_id);
    }
    public function findAll(): array
    {
        return $this->productRepository->findAll();
    }
    public function search(string $search): array
    {
        $product = $this->productRepository->searchProduct($search);
        return [
            'match' => $product['match'] ? $product['match']->toArray() : null,
            'related' => array_map(function ($product) {
                return $product->toArray();
            }, $product['related'])
        ];
    }
}
