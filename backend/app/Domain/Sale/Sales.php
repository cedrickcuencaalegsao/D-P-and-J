<?php

namespace App\Domain\Sale;

class Sales
{
    private ?int $id;
    private ?string $product_id;
    private ?int $item_sold;
    private ?float $total_sales;
    private ?string $created_at;
    private ?string $updated_at;
    public function __construct(
        ?int $id = null,
        ?int $item_sold,
        ?string $product_id = null,
        ?float $total_sales = null,
        ?string $created_at = null,
        ?string $updated_at = null,
    ) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->item_sold = $item_sold;
        $this->total_sales = $total_sales;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'item_sold' => $this->item_sold,
            'total_sales' => $this->total_sales,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public function getId()
    {
        return $this->id;
    }
    public function getProductID()
    {
        return $this->product_id;
    }
    public function getByItemSold()
    {
        return $this->item_sold;
    }
    public function getTotalSales()
    {
        return $this->total_sales;
    }
    public function Created()
    {
        return $this->created_at;
    }
    public function Updated()
    {
        return $this->updated_at;
    }
}
