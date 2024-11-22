<?php

namespace App\Application\Stock;

use App\Domain\Stock\StockRepository;
use App\Domain\Stock\Stock;

class RegisterStock
{
    private StockRepository $stockRepository;
    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }
    public function create(
        string $product_id,
        string $stocks,
        string $created_at,
        string $updated_at
    ) {
        $data = new Stock(
            null,
            $product_id,
            $stocks,
            $created_at,
            $updated_at
        );
        $this->stockRepository->create($data);
    }
    public function update(int $id, string $product_id, string $stocks, string $created_at, string $updated_at)
    {
        $validate = $this->stockRepository->findByID($id);
        if (!$validate) {
            throw new \Exception('Stock not Found!');
        }
        $updateStock = new Stock(
            id: $id,
            product_id: $product_id,
            stocks: $stocks,
            created_at: $created_at,
            updated_at: $updated_at,
        );
        $this->stockRepository->update($updateStock);
    }
    public function findByID(int $id)
    {
        return $this->stockRepository->findByID($id);
    }

    public function findByProductID(string $product_id)
    {
        return $this->stockRepository->findByProductID($product_id);
    }
    public function findAll()
    {
        return $this->stockRepository->findAll();
    }
    public function buyProduct(string $product_id, int $quantity)
    {
        $this->stockRepository->buyProduct($product_id, $quantity);
    }
    public function reStocks(string $product_id, int $quantity)
    {
        $this->stockRepository->reStocks($product_id, $quantity);
    }
    public function search(string $search): array
    {
        $stock = $this->stockRepository->searchStock($search);
        return [
            'match' => $stock['match'] ? $stock['match']->toArray() : null,
            'related' => array_map(function ($stock) {
                return $stock->toArray();
            }, $stock['related']),
        ];
    }
}
