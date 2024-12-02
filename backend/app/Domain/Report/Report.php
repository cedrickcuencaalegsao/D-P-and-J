<?php

namespace App\Domain\Report;

class Report
{
    private ?int $id;
    private ?string $product_id;
    private ?string $reports;
    private ?string $created_at;
    private ?string $updated_at;
    private ?string $name;
    private ?float $total_sale;
    private ?int $item_sold;
    public function __construct(
        ?int $id = null,
        ?string $product_id = null,
        ?string $reports = null,
        ?string $created_at = null,
        ?string $updated_at = null,
        ?string $name = null,
        ?float $total_sale = null,
        ?int $item_sold = null,
    ) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->reports = $reports;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->name = $name;
        $this->total_sale = $total_sale;
        $this->item_sold = $item_sold;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'reports' => $this->reports,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'name' => $this->name,
            'total_sale' => $this->total_sale,
            'item_sold' => $this->item_sold,
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
    public function getReports()
    {
        return $this->reports;
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
