<?php

namespace App\Domain\Stock;

class Stock
{
    private int $id;
    private string $product_id;
    private int $stock;
    private string $created_at;
    private string $updated_at;
    public function __construct(int $id = null, string $product_id = null, int $stock = null, string $created_at = null, string $updated_at)
    {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->stock = $stock;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getByProductID()
    {
        return $this->product_id;
    }
    public function getStock()
    {
        return $this->stock;
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
