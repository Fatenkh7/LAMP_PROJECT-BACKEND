<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecurringIncome;
use App\Models\Admin;
use App\Models\Currency;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;


class RecurringIncomeController extends Controller
{
    // Add a Recurring Income
    public function addRecurringIncome(Request $request) {
        try {
            // Data validation 
            $data = $request->only('title', 'description', 'amount', 'currency', 'start_date', 'end_date');
            $validator = Validator::make($data, [
                'title'=>'required|string|max:255',
                'description'=>'required|string|max:255',
                'amount'=>'required|integer',
                'start_date'=>'required|date_format:Y-m-d',
                'end_date'=>'required|date|date_format:Y-m-d|after_or_equal:start_date',
                'admins_id'=>'required|exists:admins.id',
                'currencies_id'=>'required|exists:currencies.id',
                'categories_id'=>'required|exists:categories.id',
            ]);
            if($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }

            $recurringIncome = new RecurringIncome;
            $title = $request->input('title');
            $description = $request->input('description');
            $amount = $request->input('amount');
            $currency = $request->input('currency');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $currencies_id = $request->input('currencies_id');
            $currencies = Currency::find($currencies_id);
            $categories_id = $request->input('categories_id');
            $categories = Category::find($categories_id);
            $admins_id = $request->input('admins_id');
            $admins = Admin::find($admins_id);
            $recurringIncome->currencies()->associate($currencies);
            $recurringIncome->categories()->associate($categories);
            $recurringIncome->admins()->associate($admins);
            $recurringIncome->title = $title;
            $recurringIncome->description = $description;
            $recurringIncome->amount = $amount;
            $recurringIncome->currency = $currency;
            $recurringIncome->start_date = $startDate;
            $recurringIncome->end_date = $endDate;
            $recurringIncome->save();
            return response()->json([
                'message' => 'Recurring Income added successfully'
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Get a Recurring Income By ID
    public function getRecurringIncomeById(Request $request, $id) {
        try {
            $recurringIncome = RecurringIncome::find($id);
            return response()->json([
                'message' => $recurringIncome
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Get all Recurring Incomes
    public function getAllRecurringIncomes(Request $request) {
        try {
            $recurringIncome = RecurringIncome::all();
            return response()->json([
                'message' => $recurringIncome
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Update a Recurring Income By ID
    public function editRecurringIncome(Request $request, $id) {
        try {
            // Data validation 
            $data = $request->only('title', 'description', 'amount', 'currency', 'start_date', 'end_date');
            $validator = Validator::make($data, [
                'title'=>'required|string|unique:recurring_incomes|max:255',
                'description'=>'required|string|max:255',
                'amount'=>'required|integer',
                'currency'=>'required|integer',
                'start_date'=>'required|date_format:Y-m-d',
                'end_date'=>'required|date_format:Y-m-d',
            ]);
            if($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return $errors;
            }

            $recurringIncome = RecurringIncome::find($id);
            $title = $request->input('title');
            $description = $request->input('description');
            $amount = $request->input('amount');
            $currency = $request->input('currency');
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $recurringIncome->title = $title;
            $recurringIncome->description = $description;
            $recurringIncome->amount = $amount;
            $recurringIncome->currency = $currency;
            $recurringIncome->start_date = $startDate;
            $recurringIncome->end_date = $endDate;
            $recurringIncome->update();
            
            return response()->json([
                'message' => 'Recurring Income updated successfully',
                'Recurring Income' => $recurringIncome,
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    // Delete a Recurring Income By ID
    public function deleteRecurringIncome(Request $request, $id) {
        try {
            $recurringIncome = RecurringIncome::find($id);
            $recurringIncome->delete();
            return response()->json([
                'message' => 'Recurring Income deleted successfully',
            ]);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
