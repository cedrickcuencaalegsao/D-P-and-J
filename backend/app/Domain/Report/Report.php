<?php

namespace App\Domain\Report;

class Report
{
    private ?int $id;
    private ?string $product_id;
    private ?string $report;
    private ?string $created_at;
    private ?string $updated_at;
    public function __construct(
        ?int $id = null,
        ?string $product_id = null,
        ?string $report = null,
        ?string $created_at = null,
        ?string $updated_at = null
    ) {
        $this->id = $id;
        $this->product_id = $product_id;
        $this->report = $report;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
    public function toArray()
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'report' => $this->report,
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
    public function getReports()
    {
        return $this->report;
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
