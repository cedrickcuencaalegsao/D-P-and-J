<?php

namespace App\Domain\Report;

interface ReportRepository
{
    public function create(Report $report): void;
    public function update(Report $report): void;
    public function findByID(int $id): ?Report;
    public function findByProductID(string $product_id): ?Report;
    public function findAll(): array;
}
