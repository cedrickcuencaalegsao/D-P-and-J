<?php

namespace App\Application\Report;

use App\Domain\Report\Report;
use App\Domain\Report\ReportRepository;

class RegisterReport
{
    private ReportRepository $reportRepository;
    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }
    public function create(int $id, string $product_id, string $report, string $created_at, string $updated_at)
    {
        $data = new Report($id, $product_id, $report, $created_at, $updated_at);
        $this->reportRepository->create($data);
    }
    public function update(int $id, string $product_id, string $report, string $created_at, string $updated_at)
    {
        $validate = $this->reportRepository->findByID($id);
        if (!$validate) {
            throw new \Exception("Report Not Found!");
        }
        $data = new Report($id, $product_id, $report, $created_at, $updated_at);
        $this->reportRepository->update($data);
    }
    public function findByID(int $id)
    {
        return $this->reportRepository->findByID($id);
    }
    public function findByProductID(string $product_id)
    {
        return $this->reportRepository->findByProductID($product_id);
    }
    public function findAll()
    {
        return $this->reportRepository->findAll();
    }
    public function search(string $search): array
    {
        $reports = $this->reportRepository->searchReport($search);
        return [
            'match' => $reports['match'] ? $reports['match']->toArray() : null,
            'related' => array_map(function ($report) {
                return $report->toArray();
            }, $reports['related']),
        ];
    }
}
