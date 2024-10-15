<?php

namespace App\Domain\Product;

class Product
{
    private int $id;
    private string $product_id;
    private string $name;
    private float $price;
    private string $created_at;
    private string $updated_at;
    public function __construct(int $id = null, string $product_id, string $name = null, float $price = null, string $created_at = null, string $updated_at = null)
    {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->name = $name;
        $this->price = $price;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getProductID()
    {
        return $this->product_id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPrice()
    {
        return $this->price;
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
