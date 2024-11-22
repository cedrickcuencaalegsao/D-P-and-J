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
    public function create(
        int $item_sold,
        string $product_id,
        float $retailed_price,
        float $retrieve_price,
        float $total_sales,
        string $created_at,
        string $updated_at
    ) {
        $data = new Sales(
            null,
            $product_id,
            $item_sold,
            $retailed_price,
            $retrieve_price,
            $total_sales,
            $created_at,
            $updated_at
        );
        $this->saleRepository->create($data);
    }
    public function update(int $id, int $item_sold, float $retailed_price, string $product_id, float $total_sales, string $created_at, string $updated_at)
    {
        $validate = $this->saleRepository->findByID($id);
        if (!$validate) {
            throw new \Exception('Sales not Found!');
        }
        $data = new Sales(
            id: null,
            item_sold: $item_sold,
            product_id: $product_id,
            retailed_price: $retailed_price,
            retrieve_price: $total_sales,
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
    public function productSales(string $product_id, int $quantity)
    {
        return $this->saleRepository->productSales($product_id, $quantity);
    }
    public function search(string $search)
    {
        $sales = $this->saleRepository->searchSales($search);
        return [
            'match' => $sales['match'] ? $sales['match']->toArray() : null,
            'related' => array_map(
                function ($sale) {
                    return $sale->toArray();
                },
                $sales['related']
            )
        ];
    }
}
