<?php

namespace App\Http\Controllers\Reports\API;

use App\Domain\Report\ReportRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsAPIController extends Controller
{
    private ReportRepository $reportRepository;
    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }
    public function getAll()
    {
        $reportModel = $this->reportRepository->findAll();
        $reports = array_map(fn($reportModel) => $reportModel->toArray(), $reportModel);
        return response()->json(compact('reports'));
    }
}
