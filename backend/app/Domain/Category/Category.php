<?php

namespace App\Domain\Category;

class Category
{
    private int $id;
    private string $product_id;
    private string $category;
    private string $created_at;
    private string $updated_at;

    public function __construct(int $id = null, string $product_id = null, string $category = null, string $created_at = null, string $updated_at = null)
    {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->category = $category;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
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
}
