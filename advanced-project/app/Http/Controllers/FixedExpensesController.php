<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\FixedExpenses;
class FixedExpensesController extends Controller
{
    public function addfixedexpenses(Request $request){
            $fixedExpenses = new FixedExpenses;
            $title = $request->input('title');
            $description = $request->input('description');
            $amount = $request->input('amount');
            $date = $request->input('date');
        
            $fixedExpenses->title = $title;
            $fixedExpenses->description = $description;
            $fixedExpenses->amount = $amount;
            
            // create a Carbon instance from the date string
            $carbonDate = Carbon::parse($date);
            // format the date string for MySQL
            $fixedExpenses->date = $carbonDate->format('Y-m-d');
            
            $fixedExpenses->save();
            
            return response()->json([
                'message'=> "fixed expenses created"
            ]);
            
            $fixedExpenses->save();
            
            return response()->json([
                'message'=> "fixedexpeses created"
            ]);
    }
        public function getallFixedexpenses(Request $request){
            $fixedExpenses = FixedExpenses::all();
            return response()->json([
                'message' => $fixedExpenses
            ]);
    }
    public function editFixedexpenses (Request $request ,$id){
        $fixedExpenses = FixedExpenses::find($id);
        $inputs = $request->except('_method');
        $fixedExpenses -> update($inputs);
        return response()->json([
            'message' => 'fixed expenses updated successfully',
            'fixedExpenses' => $fixedExpenses,
        ]);
    }
    public function deleteFixedexpenses (Request $request , $id){
        $fixedExpenses = FixedExpenses::find($id);
        $fixedExpenses -> delete();
        return response()->json([
            'messege'=>'delete fixed expenses successfully',
            'fixedExpenses'=> $fixedExpenses
        ]);
    }
}

