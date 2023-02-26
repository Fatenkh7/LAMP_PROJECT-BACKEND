<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FixedIncome;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Currency;
use Illuminate\Support\Facades\Validator;

class FixedIncomeController extends Controller
{
    public function addfixedincomes(Request $request){
        try {
            $FixedIncome= new FixedIncome;
            $admins_id = $request->input('admins_id');
            $admins = Admin::find($admins_id);
            $FixedIncome->admins()->associate($admins);

            $categories_id = $request->input('categories_id');
            $categories = Category::find($admins_id);
            $FixedIncome->admins()->associate($categories);

            $currencies_id = $request->input('categories_id');
            $currencies = Currency::find($admins_id);
            $FixedIncome->admins()->associate($currencies);

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
        $FixedIncome = new FixedIncome();
        $title = $request->input('title');
        $description = $request->input('description');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $datetime = $request->input('datetime');

        // return "test";
        $FixedIncome->title = $title;
        $FixedIncome->description = $description;
        $FixedIncome->amount = $amount;
        $FixedIncome->currency = $currency;
        $FixedIncome->date_time = $datetime;

        $FixedIncome->save();
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
        $fixedincomes = FixedIncome::all();
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
            $fixedincomes = FixedIncome::find($id)->get();
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
            $fixedincomes = FixedIncome::find($id);
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
            $fixedincomes = FixedIncome::find($id);
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
