<?php

namespace App\Domain\Stock;

class Stock
{
    private ?int $id;
    private ?string $product_id;
    private ?int $stocks;
    private ?string $created_at;
    private ?string $updated_at;
    public function __construct(
        ?int $id = null,
        ?string $product_id = null,
        ?int $stocks = null,
        ?string $created_at = null,
        ?string $updated_at
    ) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->stocks = $stocks;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'stocks' => $this->stocks,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public function getId()
    {
        return $this->id;
    }
    public function getByProductID()
    {
        return $this->product_id;
    }
    public function getStocks()
    {
        return $this->stocks;
    }
    public function created()
    {
        return $this->created_at;
    }
    public function updated()
    {
        return $this->updated_at;
    }
}
