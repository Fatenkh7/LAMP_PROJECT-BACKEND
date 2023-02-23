<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Recurringexpense;

class Recurringexpensescontroller extends Controller
{
    public function addRecurringexpenses(Request $request){
            $recurringexpenses = new Recurringexpense;
            $title = $request->input('title');
            $description = $request->input('description');
            $amount = $request->input('amount');
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            $recurringexpenses ->title =$title;
            $recurringexpenses ->description=$description;
            $recurringexpenses ->amount=$amount;
            $recurringexpenses ->startDate=$startDate;
            $recurringexpenses ->endDate=$endDate;
            $recurringexpenses ->save();
            return response()->json([
                'message'=>'create recurringexpenses succes'
            ]);
    }
    public function getallRecurringexpenses(Request $request){
        $recurringexpenses = Recurringexpense::all();
        
        return response()->json([
            'message'=>$recurringexpenses
        ]);
    }
    public function editRecurringexpenses(Request $request , $id){
        $recurringexpenses = Recurringexpense::find($id);
        $inputs = $request->except('_method');
        $recurringexpenses -> update($inputs);

        return response()->json([
            'message'=> 'update recurringexpenses succes'
        ]);
    }
    public function deleteRecurringexpenses(Request $request ,$id){
    $recurringexpenses = Recurringexpense::find($id);

    $recurringexpenses -> delete();

    return response()->json([
        'message'=>'delete succs',
    ]);
    }
}
