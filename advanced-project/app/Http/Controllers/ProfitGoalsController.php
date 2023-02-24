<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profit_goals;
use Carbon\Carbon;

class ProfitGoalsController extends Controller
{
    public function getAll(Request $request)
    {
        $profitGoals = Profit_goals::all();
        return response()->json([
            'message' => $profitGoals
        ]);
    }


    public function getById(Request $request, $id)
    {
        $profitGoals = Profit_goals::find($id);
        return response()->json([
            'message' => $profitGoals
        ]);
    }

    public function getByTitle(Request $request, $title)
    {
        $profitGoals = Profit_goals::where('goal_title', $title)->get();
        if ($profitGoals) {
            return response()->json([
                'success' => true,
                'data' => $profitGoals
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'profit Goals not found'
            ]);
        }
    }

    public function addprofitGoals(Request $request)
    {
        $newprofitGoals = new Profit_goals();
        $goal_title = $request->input('goal_title');
        $goal_amount = $request->input('goal_amount');
        $goal_description = $request->input('goal_description');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $newprofitGoals->goal_title = $goal_title;
        $newprofitGoals->goal_amount = $goal_amount;
        $newprofitGoals->goal_description = $goal_description;
        $newprofitGoals->start_date = $start_date;
        $newprofitGoals->end_date = $end_date;

        $carbonDate = Carbon::parse($start_date);
        $carbonDate = Carbon::parse($end_date);

        $newprofitGoals->start_date = $carbonDate->format('Y-m-d H:i:s');
        $newprofitGoals->end_date = $carbonDate->format('Y-m-d H:i:s');

        $newprofitGoals->save();
        return response()->json([
            'message' => 'profit Goals created successfully'
        ]);
    }

    public function editprofitById(Request $request, $id)
    {
        $profitGoals = Profit_goals::find($id);
        if ($profitGoals) {
            $inputs = $request->except('_method');
            $profitGoals->update($inputs);
    
            return response()->json([
                'message' => 'profit Goals updated successfully',
                'profitGoals' => $profitGoals,
            ]);
        } else {
            return response()->json([
                'message' => 'profit Goals not found',
            ], 404);
        }
    }    

    public function editprofitByTitle(Request $request, $title)
    {
        $profitGoals = Profit_goals::where('goal_title', $title)->first();
        if ($profitGoals) {
            $inputs = $request->except('_method');
            $profitGoals->update($inputs);
    
            return response()->json([
                'message' => 'profit Goals updated successfully',
                'profitGoals' => $profitGoals,
            ]);
        } else {
            return response()->json([
                'message' => 'profit Goals not found',
            ], 404);
        }
    }    


    public function deleteById(Request $request, $id)
    {
        $profitGoals = Profit_goals::find($id);
        $profitGoals->delete();
        return response()->json([
            'message' => 'profit Goal deleted successfully',
        ]);
    }

    public function deleteByTitle(Request $request, $title)
    {
        $profitGoals = Profit_goals::where('goal_title', $title)->first();
        if ($profitGoals) {
            $profitGoals->delete();
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
