<?php

namespace App\Http\Controllers;

use App\Helpers\AuthHelper;
use App\Helpers\MediaHelper;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function show()
    {
        $report = Report::with('User')->paginate(10);
        return $report;
    }
    public function setProgress(Report $report)
    {
        $report->progress();
        return $report;
    }
    public function setResolved(Report $report)
    {
        $report->resolved();
        return $report;
    }
    public function setRejected(Report $report)
    {
        $report->rejected();
        return $report;
    }
}
