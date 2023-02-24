<?php

namespace App\Http\Controllers;
use App\Models\RecurringExpense;
use Illuminate\Http\Request;

class RecurringExpenseController extends Controller
{
            // add Recurringexpenses

    public function addRecurringexpenses(Request $request){
        $recurringexpenses = new RecurringExpense;
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
// get all Recurringexpenses
public function getallRecurringexpenses(Request $request){
    $recurringexpenses = RecurringExpense::all();
    
    return response()->json([
        'message'=>$recurringexpenses
    ]);
}
// get by id Recurringexpenses
public function getByIDRecurringexpenses($id){
    $recurringexpenses = RecurringExpense::find($id);
    
    return response()->json([
        'message'=>$recurringexpenses
    ]);
}
// edit Recurringexpenses
public function editRecurringexpenses(Request $request , $id){
    $recurringexpenses = RecurringExpense::find($id);
    $inputs = $request->except('_method');
    $recurringexpenses -> update($inputs);

    return response()->json([
        'message'=> 'update recurringexpenses succes'
    ]);
}
// delete Recurringexpenses
public function deleteRecurringexpenses(Request $request ,$id){
$recurringexpenses = RecurringExpense::find($id);

$recurringexpenses -> delete();

return response()->json([
    'message'=>'delete succs',
]);
}
}
