<?php

namespace App\Domain\Product;

class Product
{
    private ?int $id;
    private ?string $product_id;
    private ?string $name;
    private ?string $image;
    private ?float $retrieve_price;
    private ?float $retailed_price;
    public ?string $category;

    public function __construct(
        ?int $id = null,
        ?string $product_id,
        ?string $name = null,
        ?float $retrieve_price = null,
        ?float $retailed_price = null,
        ?string $image = null,
        ?string $category = null,
    ) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->name = $name;
        $this->retrieve_price = $retrieve_price;
        $this->retailed_price = $retailed_price;
        $this->image = $image;
        $this->category = $category;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'name' => $this->name,
            'retrieve_price' => $this->retrieve_price,
            'retailed_price' => $this->retailed_price,
            'image' => $this->image,
            'category' => $this->category,
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
        return $this->retrieve_price;
    }
    public function getRetailedPrice()
    {
        return $this->retailed_price;
    }
    public function getImage()
    {
        return $this->image;
    }
}
