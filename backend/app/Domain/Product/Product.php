<?php

namespace App\Domain\Product;

class Product
{
    private int $id;
    private string $name;
    private string $category;
    private float $price;
    private int $stock;

    public function __construct(int $id = null, string $name = null, string $category = null, float $price = null, int $stock = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->category = $category;
        $this->price = $price;
        $this->stock = $stock;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getStock()
    {
        return $this->stock;
    }
}
