<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\fixed_incomes;
use Illuminate\Support\Facades\Validator;

class fixed_incomescontroller extends Controller
{
    public function addfixedincomes(Request $request){
        try {
            $data = $request->only('name','description','amount','currency','date');
        $validator = Validator::make($data, [
            'name'=>'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'amount'=>'required|integer|min:1|max:6',
            'currency'=>'required|integer|min:1|max:6',
            'date' => 'required|date',
        ]);
        if($validator->fails()){
            $errors = $validator->errors()->toArray();
            return $errors;
        }
        $fixed_incomes = new fixed_incomes();
        $title = $request->input('title');
        $description = $request->input('description');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $datetime = $request->input('datetime');

        // return "test";
        $fixed_incomes->title = $title;
        $fixed_incomes->description = $description;
        $fixed_incomes->amount = $amount;
        $fixed_incomes->currency = $currency;
        $fixed_incomes->date_time = $datetime;

        $fixed_incomes->save();
        return response()->json([
            'message' => 'Fixed Incomes created successfully'
        ]);
        
      }
      catch(\Exception $e) {
        return $e->getMessage();
      }
        
    }
    public function index(Request $request){
        try {
            $data = $request->only('name','description','amount','currency','date');
        $validator = Validator::make($data, [
            'name'=>'required|string|min:3|max:255',
            'description' => 'nullable|string',
            'amount'=>'required|integer|min:1|max:6',
            'currency'=>'required|integer|min:1|max:6',
            'date' => 'required|date',
        ]);
        if($validator->fails()){
            $errors = $validator->errors()->toArray();
            return $errors;
        }
        $fixedincomes = fixed_incomes::all();
        return response()->json(([
            'message' => $fixedincomes,
        ]));
        
      }
      catch(\Exception $e) {
        return $e->getMessage();
      }
       
    }
    public function getfixedincomes(Request $request, $id) {
        try {
            $data = $request->only('name','description','amount','currency','date');
            $validator = Validator::make($data, [
                'name'=>'required|string|min:3|max:255',
                'description' => 'nullable|string',
                'amount'=>'required|integer|min:1|max:6',
                'currency'=>'required|integer|min:1|max:6',
                'date' => 'required|date',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->toArray();
                return $errors;
            }
            $fixedincomes = fixed_incomes::find($id)->get();
            return response()->json([
                'message' => $fixedincomes,
            ]);
            
          }
          catch(\Exception $e) {
            return $e->getMessage();
          }
           
      
    }
    public function editfixedincomes(Request $request, $id) {
        try {
            $data = $request->only('name','description','amount','currency','date');
            $validator = Validator::make($data, [
                'name'=>'required|string|min:3|max:255',
                'description' => 'nullable|string',
                'amount'=>'required|integer|min:1|max:6',
                'currency'=>'required|integer|min:1|max:6',
                'date' => 'required|date',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->toArray();
                return $errors;
            }
            $fixedincomes = fixed_incomes::find($id);
        $inputs = $request->except('_method');
        $fixedincomes->update($inputs);

        return response()->json([
            'message' => 'Fixed Incomes updated successfully',
            'fixedincomes' => $fixedincomes,
        ]);
            
          }
          catch(\Exception $e) {
            return $e->getMessage();
          }
           
       
    }
    public function deletefixedincomes(Request $request, $id) {
        try {
            $data = $request->only('name','description','amount','currency','date');
            $validator = Validator::make($data, [
                'name'=>'required|string|min:3|max:255',
                'description' => 'nullable|string',
                'amount'=>'required|integer|min:1|max:6',
                'currency'=>'required|integer|min:1|max:6',
                'date' => 'required|date',
            ]);
            if($validator->fails()){
                $errors = $validator->errors()->toArray();
                return $errors;
            }
            $fixedincomes = fixed_incomes::find($id);
        $fixedincomes->delete();
        return response()->json([
            'message' => 'fixed incomes deleted successfully',
        ]);
          }
          catch(\Exception $e) {
            return $e->getMessage();
          }
     
    }

}
