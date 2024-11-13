<?php

namespace App\Domain\Sale;

class Sales
{
    private ?int $id;
    private ?string $product_id;
    private ?int $item_sold;
    private ?float $retailed_price;
    private ?float $retrieve_price;
    private ?float $total_sales;
    private ?string $created_at;
    private ?string $updated_at;
    public function __construct(
        ?int $id = null,
        ?string $product_id = null,
        ?int $item_sold = null,
        ?float $retailed_price = null,
        ?float $retrieve_price = null,
        ?float $total_sales = null,
        ?string $created_at = null,
        ?string $updated_at = null,
    ) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->item_sold = $item_sold;
        $this->retailed_price = $retailed_price;
        $this->retrieve_price = $retrieve_price;
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
            'retailed_price' => $this->retailed_price,
            'retrieve_price' => $this->retrieve_price,
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
    public function getRetailedPrice()
    {
        return $this->retailed_price;
    }
    public function getRetrievePrice()
    {
        return $this->retrieve_price;
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
