<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FixedExpense;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Currency;
use Exception;

class FixedExpenseController extends Controller
{
    //add fixedexpenses
    public function addfixedexpenses(Request $request)
    {
        try {

            $data = $request->only('title', 'description', 'amount', 'date');
            $validator = Validator::make($data, [
                'title' => 'required|string|min:3|max:255',
                'description' => 'required|string|min:3|max:255',
                'amount' => 'required|integer',
                'date' => 'required|date_format:Y-m-d',

            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }


            $fixedExpenses = new FixedExpense;
            $title = $request->input('title');
            $description = $request->input('description');
            $amount = $request->input('amount');
            $date = $request->input('date');
            $admins_id = $request->input('admins_id');
            $admins= Admin::find($admins_id);
            $categories_id = $request->input('categories_id');
            $categories = Category::find($categories_id);
            $currencies_id = $request->input('currencies_id');
            $currencies = Currency::find($currencies_id);
            
            $fixedExpenses->title = $title;
            $fixedExpenses->description = $description;
            $fixedExpenses->amount = $amount;
            $fixedExpenses->admins()->associate($admins);
            $fixedExpenses->categories()->associate($categories);
            $fixedExpenses->currencies()->associate($currencies);

            // create a Carbon instance from the date string
            $carbonDate = Carbon::parse($date);
            // format the date string for MySQL
            $fixedExpenses->date = $carbonDate->format('Y-m-d');

            $fixedExpenses->save();

            return response()->json([
                'message' => "fixed expenses created"
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    // get all fixedexpenses
    public function getallFixedexpenses(Request $request)
    {
        try {
            $fixedExpenses = FixedExpense::all();
            return response()->json([
                'message' => $fixedExpenses
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    // get by id fixedexpenses
    public function getByIdFixedexpenses($id)
    {
        try {
            $fixedExpenses = FixedExpense::find($id);
            return response()->json([
                'message' => $fixedExpenses
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    // edit fixedexpenses
    public function editFixedexpenses(Request $request, $id)
    {

        try {

            // validate data
            $data = $request->only('title', 'description', 'amount', 'date');
            $validator = Validator::make($data, [
                'title' => 'required|string|min:3|max:255',
                'description' => 'required|string|min:3|max:255',
                'amount' => 'required|integer',
                'date' => 'required|date_format:Y-m-d',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }

            $fixedExpenses = FixedExpense::find($id);
            $inputs = $request->except('_method');
            $fixedExpenses->update($inputs);
            return response()->json([
                'message' => 'fixed expenses updated successfully',
                'fixedExpenses' => $fixedExpenses,
            ]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function deleteFixedexpenses($id)
    {
        try {
            $fixedExpenses = FixedExpense::find($id);
            $fixedExpenses->delete();
            return response()->json([
                'message' => 'delete succs'
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
