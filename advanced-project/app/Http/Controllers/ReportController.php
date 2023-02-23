<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{

    public function getAll(Request $request)
    {
        $report = Report::all();
        return response()->json([
            'message' => $report
        ]);
    }

    public function getById(Request $request, $id)
    {
        $report = Report::find($id);
        return response()->json([
            'message' => $report
        ]);
    }

    public function getByType(Request $request, $type)
    {
        $report = Report::where('type_report', $type)->get();
        if ($report) {
            return response()->json([
                'success' => true,
                'data' => $report
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Report not found'
            ]);
        }
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

    public function editReport(Request $request, $id)
    {
        $report = Report::find($id);
        $inputs = $request->except('_method');
        $report->update($inputs);

        return response()->json([
            'message' => 'Report updated successfully',
            'report' => $report,
        ]);
    }


    public function deleteById(Request $request, $id)
    {
        $report = Report::find($id);
        $report->delete();
        return response()->json([
            'message' => 'Report deleted successfully',
        ]);
    }

    public function deleteByType(Request $request, $type)
    {
        $reports = Report::where('type_report', $type)->delete();
        return response()->json([
            'message' => $reports . ' report(s) deleted successfully',
        ]);
    }
    
}
