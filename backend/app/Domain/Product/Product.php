<?php

namespace App\Domain\Product;

class Product
{
    private ?int $id;
    private ?string $product_id;
    private ?string $name;
    private ?float $price;
    private ?string $created_at;
    private ?string $updated_at;
    public ?string $category;
    private ?string $image;

    public function __construct(
        ?int $id = null,
        ?string $product_id,
        ?string $name = null,
        ?float $price = null,
        ?string $created_at = null,
        ?string $updated_at = null,
        ?string $category = null,
        ?string $image = null,
    ) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->name = $name;
        $this->price = $price;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->category = $category;
        $this->image = $image;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'name' => $this->name,
            'price' => $this->price,
            'category' => $this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'image' => $this->image,
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
        return $this->price;
    }
    public function getImage()
    {
        return $this->image;
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
