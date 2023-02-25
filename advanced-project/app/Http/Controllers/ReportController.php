<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{

    public function getAll(Request $request)
    {
        try {
            $report = Report::all();
            return response()->json([
                'message' => $report
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving reports',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getById(Request $request, $id)
    {
        try {
            $report = Report::findOrFail($id);
            return response()->json([
                'message' => $report
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Report not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function getByType(Request $request, $type)
    {
        try {
            $report = Report::where('type_report', $type)->get();
            if ($report->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Report not found'
                ], 404);
            } else {
                return response()->json([
                    'success' => true,
                    'data' => $report
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error retrieving reports',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function addReport(Request $request)
    {
        try {
            $this->validate($request, [
                'report' => 'required|string|min:100|max:255',
                'type_report' => 'required|in:yearly,monthly,weekly',
                'admins_id' => 'required|exists:admins,id',
                'categories_id' => 'required|exists:categories,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $newreport = new Report();
            $report = $request->input('report');
            $type_report = $request->input('type_report');
            $admins_id = $request->input('admins_id');
            $categories_id = $request->input('categories_id');
            $start_date = $request->input('start_date');
            $end_date = $request->input('end_date');

            $newreport->report = $report;
            $newreport->type_report = $type_report;
            $newreport->admins_id = $admins_id;
            $newreport->categories_id = $categories_id;
            $newreport->start_date = $start_date;
            $newreport->end_date = $end_date;

            $newreport->save();
            return response()->json([
                'message' => 'Report created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function editReport(Request $request, $id)
{
    try {
        // Check if the $id correct
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid report ID'
            ], 400);
        }

        // Check if the report exists
        $report = Report::find($id);
        if (!$report) {
            return response()->json([
                'success' => false,
                'message' => 'Report not found'
            ], 404);
        }

        // Validate the request inputs
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:bug,feature request,other',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update the report
        $report->title = $request->input('title');
        $report->description = $request->input('description');
        $report->category = $request->input('category');
        $report->save();

        return response()->json([
            'success' => true,
            'message' => 'Report updated successfully',
            'report' => $report,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating report',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function deleteById(Request $request, $id)
    {
        try {
            $report = Report::find($id);
            if (!$report) {
                return response()->json([
                    'success' => false,
                    'message' => 'Report not found'
                ], 404);
            }
            $report->delete();
            return response()->json([
                'success' => true,
                'message' => 'Report deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteByType(Request $request, $type)
    {
        try {
            $reports = Report::where('type_report', $type)->delete();
            if (!$reports) {
                return response()->json([
                    'success' => false,
                    'message' => 'Reports not found'
                ], 404);
            }
            return response()->json([
                'success' => true,
                'message' => $reports . ' report(s) deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting reports',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
