<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfitGoal;
use Carbon\Carbon;

class ProfitGoalController extends Controller
{
    public function getAll(Request $request)
    {
        $ProfitGoal = ProfitGoal::all();
        return response()->json([
            'message' => $ProfitGoal
        ]);
    }


    public function getById(Request $request, $id)
    {
        $ProfitGoal = ProfitGoal::find($id);
        return response()->json([
            'message' => $ProfitGoal
        ]);
    }

    public function getByTitle(Request $request, $title)
    {
        $ProfitGoal = ProfitGoal::where('goal_title', $title)->get();
        if ($ProfitGoal) {
            return response()->json([
                'success' => true,
                'data' => $ProfitGoal
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'profit Goals not found'
            ]);
        }
    }

    public function addProfitGoal(Request $request)
    {
        $newProfitGoal = new ProfitGoal();
        $goal_title = $request->input('goal_title');
        $goal_amount = $request->input('goal_amount');
        $goal_description = $request->input('goal_description');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $newProfitGoal->goal_title = $goal_title;
        $newProfitGoal->goal_amount = $goal_amount;
        $newProfitGoal->goal_description = $goal_description;
        $newProfitGoal->start_date = $start_date;
        $newProfitGoal->end_date = $end_date;

        $carbonDate = Carbon::parse($start_date);
        $carbonDate = Carbon::parse($end_date);

        $newProfitGoal->start_date = $carbonDate->format('Y-m-d H:i:s');
        $newProfitGoal->end_date = $carbonDate->format('Y-m-d H:i:s');

        $newProfitGoal->save();
        return response()->json([
            'message' => 'profit Goals created successfully'
        ]);
    }

    public function editprofitById(Request $request, $id)
    {
        $ProfitGoal = ProfitGoal::find($id);
        if ($ProfitGoal) {
            $inputs = $request->except('_method');
            $ProfitGoal->update($inputs);

            return response()->json([
                'message' => 'profit Goals updated successfully',
                'ProfitGoal' => $ProfitGoal,
            ]);
        } else {
            return response()->json([
                'message' => 'profit Goals not found',
            ], 404);
        }
    }

    public function editprofitByTitle(Request $request, $title)
    {
        $ProfitGoal = ProfitGoal::where('goal_title', $title)->first();
        if ($ProfitGoal) {
            $inputs = $request->except('_method');
            $ProfitGoal->update($inputs);

            return response()->json([
                'message' => 'profit Goals updated successfully',
                'ProfitGoal' => $ProfitGoal,
            ]);
        } else {
            return response()->json([
                'message' => 'profit Goals not found',
            ], 404);
        }
    }


    public function deleteById(Request $request, $id)
    {
        $ProfitGoal = ProfitGoal::find($id);
        $ProfitGoal->delete();
        return response()->json([
            'message' => 'profit Goal deleted successfully',
        ]);
    }

    public function deleteByTitle(Request $request, $title)
    {
        $ProfitGoal = ProfitGoal::where('goal_title', $title)->first();
        if ($ProfitGoal) {
            $ProfitGoal->delete();
            return response()->json([
                'message' => 'Profit Goal deleted successfully',
            ]);
        } else {
            return response()->json([
                'message' => 'Profit Goal not found',
            ], 404);
        }
    }
}
