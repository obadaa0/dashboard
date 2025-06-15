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
        $reports = Report::with('user')->paginate(10);
        $reports->getCollection()->transform(function ($report) {
            if ($report->predicted && is_string($report->predicted)) {
                $predictedData = json_decode($report->predicted, true);
                if (isset($predictedData['predicted_latitude']) && isset($predictedData['predicted_longitude'])) {
                    $report->predicted_latitude = (string) $predictedData['predicted_latitude'];
                    $report->predicted_longitude = (string) $predictedData['predicted_longitude'];
                    unset($report->predicted);
                }
            }
            return $report;
        });
        return $reports;
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
