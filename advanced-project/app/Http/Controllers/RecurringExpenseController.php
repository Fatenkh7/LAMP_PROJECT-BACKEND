<?php

namespace App\Http\Controllers;
use App\Models\RecurringExpense;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RecurringExpenseController extends Controller
{
            // add Recurringexpenses

    public function addRecurringexpenses(Request $request){
        try {
            //validate data

            $data = $request->only('title', 'description', 'amount', 'startDate', 'endDate');
            $validator = Validator::make($data, [
                'title' => 'required|string|min:3|max:255',
                'description' => 'required|string|min:3|max:255',
                'amount' => 'required|integer',
                'startDate' => 'required|date_format:Y-m-d',
                'endDate' => 'required|date_format:Y-m-d',

            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }

            $recurringexpenses = new RecurringExpense;
            $title = $request->input('title');
            $description = $request->input('description');
            $amount = $request->input('amount');
            $startDate = $request->input('startDate');
            $endDate = $request->input('endDate');

            $recurringexpenses->title = $title;
            $recurringexpenses->description = $description;
            $recurringexpenses->amount = $amount;
            $recurringexpenses->startDate = $startDate;
            $recurringexpenses->endDate = $endDate;
            $recurringexpenses->save();
            return response()->json([
                'message' => 'create recurringexpenses succes'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
}
// get all Recurringexpenses
public function getallRecurringexpenses(Request $request){
    try{
        $recurringexpenses = RecurringExpense::all();

        return response()->json([
            'message' => $recurringexpenses
        ]);
    }catch(\Exception $e){
        return$e->getMessage();
    }
    
}
// get by id Recurringexpenses
public function getByIDRecurringexpenses($id){
    try{
        $recurringexpenses = RecurringExpense::find($id);

        return response()->json([
            'message' => $recurringexpenses
        ]);
    }catch (\Exception $e){
        return $e->getMessage();
    }
}
// edit Recurringexpenses
public function editRecurringexpenses(Request $request , $id){
    try{
        //validation data
        $data = $request->only('title','description','amount','startDate','endDate');
        $validator = Validator::make($data,[
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3|max:255',
            'amount' => 'required|integer',
            'startDate' => 'required|date_format:Y-m-d',
            'endDate' => 'required|date_format:Y-m-d',
        ]);
        if($validator ->fails()){
            $errors= $validator->errors()->toArray();
            return $errors;
        }


    $recurringexpenses = RecurringExpense::find($id);
    $inputs = $request->except('_method');
    $recurringexpenses->update($inputs);

    return response()->json([
        'message' => 'update recurringexpenses succes'
    ]);}
    catch(\Exception $e){
        return $e->getMessage();
    }
}
// delete Recurringexpenses
public function deleteRecurringexpenses($id){
try{
    $recurringexpenses = RecurringExpense::find($id);

    $recurringexpenses->delete();

    return response()->json([
        'message' => 'delete succs',
    ]);}
    catch(\Exception $e){
        return $e->getMessage();
    }
}
}
