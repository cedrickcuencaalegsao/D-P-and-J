<?php

namespace App\Infrastructure\Persistence\Eloquent\Report;

use App\Domain\Report\ReportRepository;
use App\Domain\Report\Report;

class EloquentReportRepository implements ReportRepository
{
    public function findByID(int $id): ?Report
    {
        $reportModel = ReportModel::find($id);
        if (!$reportModel) {
            return null;
        }
        return new Report(
            $reportModel->id,
            $reportModel->product_id,
            $reportModel->reports,
            $reportModel->created_at,
            $reportModel->updated_at
        );
    }
    public function findByProductID(string $product_id): ?Report
    {
        $reportModel = ReportModel::find($product_id);
        if (!$reportModel) {
            return null;
        }
        return new Report(
            $reportModel->id,
            $reportModel->product_id,
            $reportModel->reports,
            $reportModel->created_at,
            $reportModel->updated_at
        );
    }
    public function create(Report $report): void
    {
        $reportModel = ReportModel::find($report->getId()) ?? new ReportModel();
        $reportModel->id = $report->getId();
        $reportModel->product_id = $report->getProductID();
        $reportModel->reports = $report->getReports();
        $reportModel->created_at = $report->created();
        $reportModel->updated_at = $report->updated();
        $reportModel->save();
    }
    public function update(Report $report): void
    {
        $reportModel = ReportModel::find($report->getId()) ?? new ReportModel();
        $reportModel->id = $report->getId();
        $reportModel->product_id = $report->getProductID();
        $reportModel->reports = $report->getReports();
        $reportModel->created_at = $report->created();
        $reportModel->updated_at = $report->updated();
        $reportModel->save();
    }
    public function findAll(): array
    {
        return ReportModel::all()->map(fn($reportModel) => new Report(
            id: $reportModel->id,
            product_id: $reportModel->product_id,
            reports: $reportModel->reports,
            created_at: $reportModel->created_at,
            updated_at: $reportModel->updated_at,
        ))->toArray();
    }
}
