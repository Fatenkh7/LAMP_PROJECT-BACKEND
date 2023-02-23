<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class report_controller extends Controller
{

    public function getAll(Request $request)
    {
        $reports = Report::all();
        return response()->json([
            'message' => $reports
        ]);
    }

    public function getById(Request $request, $id)
    {
        $report = Report::find($id)->get();
        return response()->json([
            'message' => $report
        ]);
    }

    public function getByType(Request $request, $type)
    {
        $report = Report::find($type)->get();
        return response()->json([
            'message' => $report
        ]);
    }

    public function addReport(Request $request)
    {
        $newreport = new Report();
        $report = $request->input('report');
        $type_report = $request->input('type_report');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $newreport->report = $report;
        $newreport->type_report = $type_report;
        $newreport->start_date = $start_date;
        $newreport->end_date = $end_date;

        $newreport->save();
        return response()->json([
            'message' => 'Report created successfully'
        ]);
    }
}
