<?php

namespace App\Domain\Category;

class Category
{
    private ?int $id;
    private ?string $product_id;
    private ?string $category;
    private ?string $created_at;
    private ?string $updated_at;
    private ?string $name;
    private ?int $stock;

    public function __construct(
        ?int $id = null,
        ?string $product_id = null,
        ?string $category = null,
        ?string $created_at = null,
        ?string $updated_at = null,
        ?string $name = null,
        ?int $stock = null,
    ) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->category = $category;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->name = $name;
        $this->stock = $stock;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'category' => $this->category,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'name' => $this->name,
            'stock' => $this->stock,
        ];
    }
    public function getId()
    {
        return $this->id;
    }
    public function getPoductId()
    {
        return $this->product_id;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function Created()
    {
        return $this->created_at;
    }
    public function Update()
    {
        return $this->updated_at;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getStock()
    {
        return $this->stock;
    }
}
