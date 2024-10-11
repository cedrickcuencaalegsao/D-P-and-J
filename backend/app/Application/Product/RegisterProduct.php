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
    public function create(int $id, string $name, string $category, float $price, int $stock)
    {
        $data = new Product($id, $name, $category, $price, $stock);
        $this->productRepository->create($data);
    }
    public function update(int $id, string $name, string $category, float $price, int $stock)
    {
        $validate = $this->productRepository->findByID($id);

        if (!$validate) {
            throw new \Exception('Product Not found!');
        }
        $updateProduct = new Product(
            id: $id,
            name: $name,
            category: $category,
            price: $price,
            stock: $stock,
        );
        $this->productRepository->update($updateProduct);
    }

    public function findByID(int $id)
    {
        return $this->productRepository->findByID($id);
    }
    public function findAll(): array
    {
        return $this->productRepository->findAll();
    }
}
