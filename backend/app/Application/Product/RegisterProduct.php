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
    public function create(int $id, string $product_id, string $name, string $category, float $price,  string $created_at)
    {
        $data = new Product($id, $product_id, $name, $category, $price,);
        $this->productRepository->create($data);
    }
    public function update(int $id, string $product_id, string $name, float $price, string $created_at, string $updated_at)
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
            created_at: $created_at,
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
}
