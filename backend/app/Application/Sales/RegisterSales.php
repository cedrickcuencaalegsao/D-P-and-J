<?php

namespace App\Application\Sales;

use App\Domain\Sale\SaleRepository;
use App\Domain\Sale\Sales;

class RegisterSales
{
    private SaleRepository $saleRepository;
    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }
    public function create(int $id, int $item_sold, string $product_id, float $total_sales, string $created_at, string $updated_at)
    {
        $data = new Sales($id, $item_sold, $product_id, $total_sales, $created_at, $updated_at);
        $this->saleRepository->create($data);
    }
    public function update(int $id, int $item_sold, string $product_id, float $total_sales, string $created_at, string $updated_at)
    {
        $validate = $this->saleRepository->findByID($id);
        if (!$validate) {
            throw new \Exception('Sales not Found!');
        }
        $data = new Sales(
            id: $id,
            item_sold: $item_sold,
            product_id: $product_id,
            total_sales: $total_sales,
            created_at: $created_at,
            updated_at: $updated_at,
        );
        $this->saleRepository->update($data);
    }
    public function findByID(int $id)
    {
        return $this->saleRepository->findByID($id);
    }
    public function findByProductID(string $product_id)
    {
        return $this->saleRepository->findByProductID($product_id);
    }
    public function findAll(): array
    {
        return $this->saleRepository->findAll();
    }
}
